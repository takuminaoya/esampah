<?php

namespace App\Http\Controllers;

use App\Models\DetailPembayaran;
use App\Models\KodeDistribusi;
use App\Models\Pegawai;
use App\Models\Pembayaran;
use App\Models\Pendapatan;
use App\Models\Rekanan;
use App\Models\StatusPelanggan;
use App\Models\User;
use App\Http\Requests\CustomerVerificationRequest;
use App\Modules\Whapify;
use App\Services\CustomerService;
use App\Services\DistributionCodeService;
use App\Services\VerificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifikasiController extends Controller
{
    protected $verificationService;

    public function __construct(VerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function getVerifikasiPelanggan(){
        $customerService = new CustomerService();
        $customers = $customerService->getUnverifiedCustomers();

        $distributionCodeService = new DistributionCodeService();
        $distributionCodes = $distributionCodeService->getDistributionCodes();

        $partners = Rekanan::all();
        return view('verifikasi.verify-pelanggan',compact(['customers','distributionCodes','partners']));
    }

    public function postVerifikasiPelanggan(CustomerVerificationRequest $request, User $user)
    {
        try {
            $validatedData = $request->validated();
            
            $result = $this->verificationService->verifyCustomer($validatedData, $user);

            // oka . send wa
            $wa = new Whapify();
            $wa->sendSingleChat(reformatNoHp($user->telp), $request->wa_message);
        
            return redirect()->back()
                ->with('status', $result['status'])
                ->with('message', $result['message']);
        } catch (\Exception $th) {
            Log::error($th->getMessage(), ['trace' => $th->getTrace()]);
            return redirect()->back()
                ->with('status', 'error')
                ->with('message', 'Terjadi kesalahan saat memverifikasi pelanggan');
        }
    }

    public function getVerifikasiTransfer(){
        $transfers = Pembayaran::where('isTransfer',true)->where('verifikasi_bendahara',false)->get();
        $details = DetailPembayaran::whereHas('pembayaran', function($q){
            $q->where('isTransfer',true)->where('verifikasi_bendahara',false);
        })->get();

        return view('verifikasi.verify-transfer',compact(['transfers','details']));
    }

    public function postVerifikasiTransfer(Pembayaran $pembayaran){
        $pembayaran->update(['verifikasi_bendahara'=>true]); 

        $this->storePendapatanByVerifikasi($pembayaran);

        return redirect()->back()
            ->with('status','success')
            ->with('message','Pembayaran berhasil diverifikasi');
    }

    public function storePendapatanByVerifikasi($pembayaran){
        $details = DetailPembayaran::where('pembayaran_id',$pembayaran->id)->get();

        foreach ($details as $key => $detail) {
            $pendapatan = [
                'bulan_bayar' => $detail->bulan_bayar,
                'isTransfer' => $pembayaran->isTransfer,
                'jumlah' => $detail->biaya,
                'pembayaran_id'=> $pembayaran->id
            ];

            if ($pembayaran->isTransfer == true){
                $pendapatan['keterangan'] = 'Transfer '.$pembayaran->user->nama;
            }else{
                $pendapatan['keterangan'] = "Collect umum bulan ".Carbon::parse($detail->bulan_bayar)->format('F');
            }

            Pendapatan::create($pendapatan);
        }
    }

    public function getVerifikasiSetoran(){
        $totals = Pembayaran::whereHas('pegawai', function($q){
            $q->where('level','petugas');
        })->where('status',true)->where('verifikasi_bendahara',false)->groupBy('pegawai_id')->selectRaw('pegawai_id,sum(total) as total')->get();

        $petugass = Pegawai::with('pembayaran')->whereHas('pembayaran', function($q){
            $q->where('status',true)->where('verifikasi_bendahara',false);
        })->get();

        return view('verifikasi.verify-setoran',compact(['totals','petugass']));
    }

    public function postVerifikasiSetoran(Pegawai $petugas, Request $request){

        Pembayaran::whereIn('id',$request->setoran)
            ->update(['verifikasi_bendahara' => true]);

        $pembayarans = Pembayaran::whereIn('id',$request->setoran)->get();

        foreach ($pembayarans as $key => $pembayaran) {
            $this->storePendapatanByVerifikasi($pembayaran);
        }

        $user = User::find($request->id);
        $status = $request->status == 1 ? "Diambil hari ini." : "Tidak Diambil dengan alasan " . $request->alasan ;
        $pesan = "Selamat siang saudara " . $user->nama . ", Sampah anda telah " . $status;

        $wa = new Whapify();
        $wa->sendSingleChat("6282359351605", $pesan);

        return redirect()->back()
            ->with('status','success')
            ->with('message','Setoran berhasil diverifikasi');
    }

    public function getNonaktif(){
        $pelanggans = User::where('verified',true)->where('status',false)->get();
        return view('verifikasi.nonaktif',compact('pelanggans'));
    }

    public function getKadaluarsa(Request $request){
        if(!$request->waktu){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','<',Carbon::today()->subDays(90)->format('Y-m-d'))
                ->get();
        }elseif($request->waktu == "1"){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','=',Carbon::today()->subDays(89)->format('Y-m-d'))
                ->get();
        }elseif($request->waktu == "3"){
            $pelanggans = User::where('verified',true)
                ->where('rekanan_id',1)
                ->where('status',true)
                ->where('tenggat_bayar','=',Carbon::today()->subDays(87)->format('Y-m-d'))
                ->get();
        }
        
        return view('verifikasi.kadaluarsa',compact('pelanggans'));
    }

    // public function postKadaluarsa(User $user){
    //     $user->update(['status' => 0]);
     
    //     return redirect()->back()
    //         ->with('status','success')
    //         ->with('message','User dianonaktifkan');  
    // }

    public function sync(){
        set_time_limit(0);
        $t = User::where('verified',true)->where('rekanan_id',1)->get();
        foreach ($t as $key => $user) {
            $jumlah = count(StatusPelanggan::where('user_id',$user->id)->whereHas('user', function($q){
                $q->where('rekanan_id',1);
            })->where('bulan',Carbon::today()->format('Y-m'))->get());
            if($user->status == false && $jumlah == 0){
                StatusPelanggan::create([
                    'user_id' => $user->id,
                    'bulan' => Carbon::today()->format('Y-m'),
                    'status' => false
                ]);
            }
            elseif($user->status == true && $jumlah == 0){
                StatusPelanggan::create([
                    'user_id' => $user->id,
                    'bulan' => Carbon::today()->format('Y-m'),
                    'status' => true
                ]);
            }
        }
        //update tenggat bayar (CASE 1)
        $users = User::where('status',true)->where('tenggat_bayar','<',Carbon::today()->format('Y-m-d'))->get();
       
        $update_tenggat = 0;

        $array = [];
        foreach ($users as $user){
            $id = User::where('id',$user->id)->whereHas('pembayaran', function($q) use($user){
                $q->where('verifikasi_bendahara',true)->whereHas('detailPembayaran',function($p) use($user){
                    $p->whereMonth('bulan_bayar',Carbon::parse($user->tenggat_bayar)->subDays(30)->format('m'));
                });
            })->value('id');
            array_push($array,$id);
            $jml = User::where('id',$id)->update(['tenggat_bayar' => getTenggatBayar($user->tenggat_bayar)]);

            $update_tenggat = $update_tenggat + $jml;

        }
       // CREATE STATUS (CASE 1)
        // foreach ($array as $key => $id) {
        //     $tenggat = User::where('id',$id)->value('tenggat_bayar');
        //     if($id !== null){
        //         StatusPelanggan::create([
        //             'user_id' => $id,
        //             'bulan' => Carbon::parse($tenggat)->addDays(90)->format('Y-m'),
        //             'status' => true
        //         ]);
        //         // User::where('id',$id)->update(['status' => true]);
        //     }
        // }
        // SELESAI
       
        // $overdues = User::where('status',true)->where('tenggat_bayar','<',Carbon::today()->subDays(90))->get();
        // // update status pelanggan
        // $user_nonaktif = 0;
        // foreach ($overdues as $user){
        //    $jml = User::where('id',$user->id)->update(['status' => false]);
        //     StatusPelanggan::create([
        //         'user_id' => $user->id,
        //         'bulan' => Carbon::parse($user->tenggat_bayar)->addDays(90)->format('Y-m'),
        //         'status' => false
        //     ]);
        //     $user_nonaktif = $user_nonaktif + $jml;
        // }
        

        // $overdues = User::where('status',false)->
        // User::where('')
        // $tes = User::where('status',false)->where('tenggat_bayar','<',Carbon::today()->format('Y-m-d'))->get();

        // foreach ($tes as $user){
        //     $id = User::where('id',$user->id)->whereHas('pembayaran', function($q) use($user){
        //         $q->where('verifikasi_bendahara',true)->whereHas('detailPembayaran',function($p) use($user){
        //             $p->whereMonth('bulan_bayar',Carbon::parse($user->tenggat_bayar)->subDays(30)->format('m'));
        //         });
        //     })->value('id');
        //     array_push($array,$id);
        //     $jml = User::where('id',$id)->update(['tenggat_bayar' => getTenggatBayar($user->tenggat_bayar)]);

       
        //     $update_tenggat = $update_tenggat + $jml;

        // }

        // $bulan = StatusPelanggan::where('user_id',$id)->orderBy('bulan','DESC')->value('bulan');
        // Carbon::parse($bulan)->addDays(30)->format('m');

        // $aktif = User::where('status',false)->where('tenggat_bayar','<',Carbon::today()->subDays(90))->get();
        return redirect()->back()
            ->with('status','success')
            ->with('message',$update_tenggat.' user berhasil diupdate');
    }

    public function sendNotification(Request $request)
    {
        // Log the request data for debugging
        Log::info('WhatsApp notification request:', $request->all());
        
        $request->validate([
            'phone' => 'required',
            'message' => 'required'
        ]);

        // Format phone number if needed
        $phone = $request->input('phone');
        
        Log::info('Original phone number:', ['phone' => $phone]);
        
        // Remove any non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        Log::info('After removing non-numeric characters:', ['phone' => $phone]);
        
        // Ensure it starts with country code
        if (substr($phone, 0, 2) !== '62') {
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            } else {
                $phone = '62' . $phone;
            }
        }
        
        Log::info('Final formatted phone number:', ['phone' => $phone]);

        try {
            $response = Http::asMultipart()
                ->post('https://whapify.id/api/send/whatsapp', [
                    'secret' => env('WHAPIFY_API_KEY'),
                    'account' => env('WHAPIFY_ACCOUNT_ID', '175655669335f4a8d465e6e1edc05f3d8ab658c55168b2ed9584827'),
                    'recipient' => $phone,
                    'type' => 'text',
                    'message' => $request->message
                ]);

            if ($response->successful()) {
                Log::info('WhatsApp notification sent successfully');
                return response()->json([
                    'status' => 'success',
                    'message' => 'WhatsApp notification sent successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send WhatsApp notification: ' . $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send WhatsApp notification: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getFee($distributionCodeId){
        $distributionCodeService = new DistributionCodeService();
        return $distributionCodeService->getFee($distributionCodeId);
    }
}
