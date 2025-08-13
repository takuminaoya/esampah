<?php

namespace App\Http\Controllers;

use App\Models\Banjar;
use App\Models\KodeDistribusi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{   
    public function getRegistrasi()
    {
        $token = env('TOKEN_API');
        $url = 'https://desaungasan.badungkab.go.id/api/banjar?token='.$token;
        $response = Http::get($url);
        $datas = $response->object();
        $banjars = $datas->data;
        
        $distribusis = KodeDistribusi::all();
        return view('registrasi',compact(['banjars','distribusis']));
    }

    public function postRegistrasi(Request $request)
    {
        $url = 'http://desaungasan.badungkab.go.id/api/penduduk/nik/'.$request->nik;
        $response = Http::get($url);
        $datas = $response->object();

        if($datas->data == 1){
            $request->validate([
                'kategori' => 'required',
                'nama' => 'required',
                'nik'  => 'required',
                'alamat' => 'required',
                'telp'  => 'required',
                'banjar' => 'required',
                'username' => 'required',
                'password' => 'required',
                'konfirmasi_password' => 'required'
            ]);
    
            if ($request->password == $request->konfirmasi_password){
                User::create([
                    'nama' => $request->nama,
                    'kode_distribusi_id' => $request->kategori,
                    'nik'  => $request->nik,
                    'alamat' => $request->alamat,
                    'telp'  => $request->telp,
                    'usaha' => $request->nama_usaha,
                    'banjar_id' => $request->banjar,
                    'username' => $request->username,
                    'password' => bcrypt($request->password),
                ]);
                return redirect()->back()
                    ->with('status','success')
                    ->with('message','Regsitrasi berhasil. Tunggu verifikasi untuk mulai login');
            }
            else{
                return redirect()->back()
                    ->with('status','error')
                    ->with('message','Registrasi Gagal. Periksa data yang Anda input');
            }
        }else{
            return redirect()->back()
                    ->with('status','error')
                    ->with('message','Registrasi Gagal. NIK Anda tidak terdaftar sebagai penduduk Desa Ungasan');
        }
    }

    public function checkVerifikasi(Request $request)
    {
        $status = User::where('nik',$request->check)->value('verified');
        $nik = count(User::where('nik',$request->check)->get());
        if($nik == 0){
            return redirect()->back()
                ->with('status','error')
                ->with('message','Anda belum melakukan pendaftaran');
        }
        elseif($nik !== 0 && $status == false){
            return redirect()->back()
                ->with('status','warning')
                ->with('message','Pendaftaran Anda belum diverifikasi. Mohon untuk menunggu');
        }
        elseif($nik !== 0 && $status == true){
            return redirect('login')
                ->with('status','success')
                ->with('message','Pendaftaran Anda telah diverifikasi. Silahkan melakukan login');
        }
    }

    public function getLoginUser()
    {
        return view('login');
    }

    public function postLoginUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('user')->attempt(['username'=>$request->username,'password'=>$request->password, 'verified'=>true]))
        {   
            $request->session()->regenerate();
            
            return redirect()->intended('dashboard');
        }else{
            return back()
                ->with('status','error')
                ->with('message','username atau password yang Anda masukkan salah');
        }
     }

    public function getLoginPegawai()
    {
        return view('login-pegawai');
    }

    public function postLoginPegawai(Request $request)
    {
        $login = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if(Auth::guard('pegawai')->attempt(['username'=>$request->username,'password'=>$request->password]))
        {   
            $request->session()->regenerate();
             return redirect()->intended('dashboard');
        }
        else{
            return back()
                ->with('status','error')
                ->with('message','username atau password yang Anda masukkan salah');
        }
     }

    public function logout()
    {
        $guards = ["pegawai","user"];
        foreach ($guards as $guard) {
            if(Auth::guard($guard)->check()){
                if($guard == "user"){
                    Auth::guard($guard)->logout();
                    return redirect('login');
                }else{
                    Auth::guard($guard)->logout();
                    return redirect('login-pegawai');
                }
            }
          
        }
    }

}
