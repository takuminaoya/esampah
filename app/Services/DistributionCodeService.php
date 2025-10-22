<?php

namespace App\Services;

use App\Models\KodeDistribusi;
use Illuminate\Support\Facades\Log;

class DistributionCodeService
{
    /**
     * Get all distribution codes
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getDistributionCodes()
    {
        try {
            return KodeDistribusi::all();
        } catch (\Exception $e) {
            Log::error('Error getting all distribution codes: ' . $e->getMessage(), [
                'trace' => $e->getTrace()
            ]);
            return collect();
        }
    }

    /**
     * Get distribution code by ID
     * 
     * @param int $id
     * @return KodeDistribusi|null
     */
    public function getDistributionCodeById($id)
    {
        try {
            return KodeDistribusi::find($id);
        } catch (\Exception $e) {
            Log::error('Error getting distribution code by ID: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'id' => $id
            ]);
            return null;
        }
    }

    /**
     * Get Fee (biaya) based on distribution code ID
     * 
     * @param int $distributionCodeId
     * @return int|null
     */
    public function getFee($distributionCodeId)
    {
        try {
            $distributionCode = KodeDistribusi::find($distributionCodeId);
            return $distributionCode ? $distributionCode->jumlah : null;
        } catch (\Exception $e) {
            Log::error('Error getting jumlah from distribution code: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'kode_distribusi_id' => $distributionCodeId
            ]);
            return null;
        }
    }

    /**
     * Create a new distribution code
     * 
     * @param array $data
     * @return KodeDistribusi|null
     */
    public function createDistributionCode(array $data)
    {
        try {
            return KodeDistribusi::create($data);
        } catch (\Exception $e) {
            Log::error('Error creating distribution code: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'data' => $data
            ]);
            return null;
        }
    }

    /**
     * Update a distribution code
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateDistributionCode($id, array $data)
    {
        try {
            $distributionCode = KodeDistribusi::find($id);
            if (!$distributionCode) {
                return false;
            }
            
            return $distributionCode->update($data);
        } catch (\Exception $e) {
            Log::error('Error updating distribution code: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'id' => $id,
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Delete a distribution code
     * 
     * @param int $id
     * @return bool
     */
    public function deleteDistributionCode($id)
    {
        try {
            $distributionCode = KodeDistribusi::find($id);
            if (!$distributionCode) {
                return false;
            }
            
            return $distributionCode->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting distribution code: ' . $e->getMessage(), [
                'trace' => $e->getTrace(),
                'id' => $id
            ]);
            return false;
        }
    }
}
