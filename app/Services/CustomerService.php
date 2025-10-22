<?php

namespace App\Services;

use App\Models\User;
use App\Models\StatusPelanggan;
use App\Models\Rekanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    /**
     * Get all active customers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveCustomers()
    {
        try {
            return User::where('verified', true)
                ->where('status', true)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting active customers: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get all inactive customers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getInactiveCustomers()
    {
        try {
            return User::where('verified', true)
                ->where('status', false)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting inactive customers: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get all unverified customers
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnverifiedCustomers()
    {
        try {
            return User::where('verified', false)->get();
        } catch (\Exception $e) {
            Log::error('Error getting unverified customers: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get customer by ID
     *
     * @param int $id
     * @return User|null
     */
    public function getCustomerById($id)
    {
        try {
            return User::find($id);
        } catch (\Exception $e) {
            Log::error('Error getting customer by ID: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return null;
        }
    }

    /**
     * Activate a customer
     *
     * @param User $user
     * @return array
     */
    public function activateCustomer(User $user)
    {
        try {
            $user->update(['status' => true]);
            
            // Create status record for current month
            StatusPelanggan::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'bulan' => Carbon::today()->format('Y-m')
                ],
                [
                    'status' => true
                ]
            );

            return [
                'status' => 'success',
                'message' => 'Pelanggan berhasil diaktifkan'
            ];
        } catch (\Exception $e) {
            Log::error('Error activating customer: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return [
                'status' => 'error',
                'message' => 'Gagal mengaktifkan pelanggan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Deactivate a customer
     *
     * @param User $user
     * @return array
     */
    public function deactivateCustomer(User $user)
    {
        try {
            $user->update(['status' => false]);
            
            return [
                'status' => 'success',
                'message' => 'Pelanggan berhasil dinonaktifkan'
            ];
        } catch (\Exception $e) {
            Log::error('Error deactivating customer: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return [
                'status' => 'error',
                'message' => 'Gagal menonaktifkan pelanggan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Update customer data
     *
     * @param User $user
     * @param array $data
     * @return array
     */
    public function updateCustomer(User $user, array $data)
    {
        try {
            $user->update($data);
            
            return [
                'status' => 'success',
                'message' => 'Data pelanggan berhasil diperbarui'
            ];
        } catch (\Exception $e) {
            Log::error('Error updating customer: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return [
                'status' => 'error',
                'message' => 'Gagal memperbarui data pelanggan: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Get customers by rekanan
     *
     * @param int $rekananId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomersByRekanan($rekananId)
    {
        try {
            return User::where('verified', true)
                ->where('rekanan_id', $rekananId)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting customers by rekanan: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get customers with expired payments
     *
     * @param int $daysOverdue
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCustomersWithExpiredPayments($daysOverdue = 90)
    {
        try {
            return User::where('verified', true)
                ->where('status', true)
                ->where('tenggat_bayar', '<=', Carbon::today()->subDays($daysOverdue)->format('Y-m-d'))
                ->get();
        } catch (\Exception $e) {
            Log::error('Error getting customers with expired payments: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get customer statistics
     *
     * @return array
     */
    public function getCustomerStatistics()
    {
        try {
            $stats = [
                'total' => User::where('verified', true)->count(),
                'active' => User::where('verified', true)->where('status', true)->count(),
                'inactive' => User::where('verified', true)->where('status', false)->count(),
                'unverified' => User::where('verified', false)->count(),
                'by_rekanan' => []
            ];

            // Get counts by rekanan
            $rekananStats = DB::table('users')
                ->join('rekanans', 'users.rekanan_id', '=', 'rekanans.id')
                ->where('users.verified', true)
                ->select('rekanans.nama', DB::raw('count(*) as total'))
                ->groupBy('rekanans.nama')
                ->get();

            foreach ($rekananStats as $stat) {
                $stats['by_rekanan'][$stat->nama] = $stat->total;
            }

            return $stats;
        } catch (\Exception $e) {
            Log::error('Error getting customer statistics: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return [
                'total' => 0,
                'active' => 0,
                'inactive' => 0,
                'unverified' => 0,
                'by_rekanan' => []
            ];
        }
    }

    /**
     * Generate customer code based on partner ID (rekanan_id)
     * 
     * @param int $partnerId
     * @return string
     * Example: Partner Name: "Cipta Ungasan Bersih", Last Code: "1234"
     * Result: ["CUB", "CUB1235"]
     */
    public function generateCustomerCode($partnerId)
    {
        $customerCode = "";
        $partnerCode = "";
        try {
            // Generate customer code based on partner ID (rekanan_id)
            $lastCode = User::where('verified', true)
                ->where('rekanan_id', $partnerId)
                ->orderByDesc('kode_rekanan')
                ->value('kode_rekanan') ?? 0;
    
            // Get last code and increment it
            $partnerCode = $lastCode + 1;
            $partnerCode = str_pad($partnerCode, 4, '0', STR_PAD_LEFT);
    
            // Get partner name and generate acronym
            $partnerName = Rekanan::find($partnerId)?->nama ?? '';
            $words = explode(" ", $partnerName);
            $acronym = "";
    
            foreach ($words as $w) {
                $acronym .= mb_substr($w, 0, 1);
            }
            $partnerSlug = strtolower($acronym);
    
            // Combine acronym and code
            $customerCode = $partnerSlug . $partnerCode;
        } catch (\Exception $th) {
            Log::error($th->getMessage(), ['trace' => $th->getTrace()]);
        }
    
        return [$partnerCode, $customerCode];
    }
}
