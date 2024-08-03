<?php

namespace App\Services\Web;

use App\Models\Campaign;
use Carbon\Carbon;

/**
 * Class FinishCampaignService.
 */
class FinishCampaignService
{


    /**
     * quite all volunteer in this campaign
     */
    public function endCampaignVolunteersWork(Campaign $campaign)
    {
        try {
            $requests = $campaign->request()->where('status', 'مقبول')->get();
            foreach ($requests as $request) {
                $request->volunteer()->update([
                    'active' => 0
                ]);
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Reject all requests for this campaign
     */
    public function rejectAllPendingVolunteerRequests(Campaign $campaign)
    {
        try {
            $requests = $campaign->request()->where('status', 'انتظار');
            foreach ($requests as $request) {
                $request->status = 'مرفوض';
                $request->save();
            }
        } catch (\Exception $th) {
            throw $th;
        }
    }

    /**
     * Finish the campaign
     */
    public function endCampaign(Campaign $campaign)
    {
        try {
            $this->endCampaignVolunteersWork($campaign);
            $this->rejectAllPendingVolunteerRequests($campaign);
            $campaign->update([
                'is_volunteerable' => 0,
                'is_donateable' => 0,
                'end_date' => Carbon::now()
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
