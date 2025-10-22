<?php

namespace App\Services;

use App\Models\Rekanan;
use App\Models\User;
use App\Models\StatusPelanggan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerificationService
{
    /**
     * Verify a user account
     *
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function verifyCustomer($data, User $user)
    {
        try {
            $jumlah = str_replace(',', '', $data['fee']);
            $customerService = new CustomerService();
            list($partnerCode, $customerCode) = $customerService->generateCustomerCode($data['partner']);

            $tgl_verified = Carbon::today()->toDateString();
            $tenggat = $this->getTenggatBayar($tgl_verified);

            // Update user data
            User::where('id', $user->id)->update([
                'verified' => 1,
                'rekanan_id' => $data['partner'],
                'tgl_verified' => $tgl_verified,
                'biaya' => $jumlah,
                'tenggat_bayar' => $tenggat,
                'kode_rekanan' => $partnerCode,
                'kode_pelanggan' => $customerCode,
                'kode_distribusi_id' => $data['distribution_code_id']
            ]);

            // Create status record
            StatusPelanggan::create([
                'user_id' => $user->id,
                'bulan' => Carbon::today()->format('Y-m'),
                'status' => true
            ]);

            return [
                'status' => 'success',
                'message' => 'Akun telah diverifikasi'
            ];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Get tenggat bayar date
     * 
     * @param string $date
     * @return string
     */
    private function getTenggatBayar($date)
    {
        // Using the helper function if it exists
        if (function_exists('getTenggatBayar')) {
            return getTenggatBayar($date);
        }

        // Fallback implementation if helper doesn't exist
        return Carbon::parse($date)->addDays(30)->format('Y-m-d');
    }

}
