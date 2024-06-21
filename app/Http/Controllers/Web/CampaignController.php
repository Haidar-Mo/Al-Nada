<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateCampaignRequest;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use App\Notifications\NewCampaignNotification;
use App\Traits\NotificationTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    use NotificationTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $is_donateable_campaigns = Campaign::where('is_donateable', 1)->where('end_date', null)->get();
        $is_volunteerable_campaigns = Campaign::where('is_volunteerable', 1)->where('end_date', null)->get();

        return response()->json(['Donateable Campaign' => $is_donateable_campaigns, 'Volunteerable Campaign' => $is_volunteerable_campaigns], 200);
    }

    /**
     * Store a newly created campaign in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(CreateCampaignRequest $request)
    {
        DB::beginTransaction();
        try {
            $path = '';
            // check if Image exsist in request
            if ($request->file('image'))
                $path = $request->file('image')->store('Campaign', 'public');
            // create new campaign
            $campaign = Campaign::create(array_merge($request->all(), ['image' => $path]));
            // send Notifications 
            $user = User::all();
            Notification::send($user, new NewCampaignNotification($campaign));
            //$this->sendNotificationToTopic('mobile_user', 'إطلاق حملة جديدة', ["بدأ العمل بحملة" . $campaign->name]);

            DB::commit();
            return response()->json($campaign, 201);
        } catch (\Exception $e) {
            DB::rollback();
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified campaign.
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id)
    {
        $campaign = Campaign::findOrFail($id);
        $notifi = $campaign->notifications;
        return response()->json($notifi, 200);
    }

    /**
     * Update the specified resource in storage.
     * @param CreateCampaignRequest $request
     * @param string $id
     * @return JsonResponse
     */
    public function update(CreateCampaignRequest $request, string $id)
    {
        DB::beginTransaction();
        try {
            $campaign = Campaign::findOrFail($id);
            if ($request->file('image')) {
                if ($campaign->image)
                    if (Storage::exists("public/" . $campaign->image))
                        Storage::delete("public/" . $campaign->image);
                $path = $request->file('image')->store('Employee', 'public');
            } else {
                $path = $campaign->image;
            }
            $campaign->update(array_merge($request->all(), ['image' => $path]));
            DB::commit();
            return response()->json($campaign, 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    /**
     * Remove the specified campaign from storage.
     * @param string $id
     * @return null
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $campaign = Campaign::findOrFail($id);
            $path = $campaign->image;
            $campaign->delete();
            if (Storage::exists("public/" . $path))
                Storage::delete("public/" . $path);
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json($e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
