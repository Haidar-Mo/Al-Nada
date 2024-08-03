<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\DonationToCampaign;
use App\Models\Employee;
use App\Models\Volunteer;
use App\Models\VolunteerInCampaign;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{

    /**
     * Get Active Employees count -with section specification or Not-
     * @param Request $request  Section id Querue passed
     * @return JsonResponse
     */
    public function employee(Request $request)
    {
        $section = $request->input('section');
        $employyes = Employee::query();
        if ($section)
            $employyes->where('section_id', $section);

        $totalEmployees = $employyes->where('date_end_working', null)->get()->count();
        return response()->json(['Employees count' => $totalEmployees], 200);
    }

    public function volunteer()
    {
        $volunteers = Volunteer::all();
        $campaignVolunteers = VolunteerInCampaign::all();

        $totalVolunteers = $volunteers->count();
        $totalCampaignVolunteers = $campaignVolunteers->count();

        $activeVolunteers = Volunteer::where('active', 1)->get();
        $activeCampaignVolunteers = VolunteerInCampaign::where('active', 1)->get();

        $totalActiveVolunteers = $activeVolunteers->count();
        $totalActiveCampaignVolunteers = $activeCampaignVolunteers->count();

        return response()->json([
            'Volunteers count' => $totalVolunteers,
            'Campaign Volunteers count' => $totalCampaignVolunteers,
            'Active Volunteers count' => $totalActiveVolunteers,
            'Active Campaign Volunteers count' => $totalActiveCampaignVolunteers
        ], 200);
    }

    public function financialDonations(Request $request)
    {
        $date_1 = $request->input('first_date');
        $date_2 = $request->input('second_date');

        $donations = Donation::where('type', 'مالي')->whereBetween('created_at', [$date_1, $date_2])->get();
        $totalDonations = $donations->count();
        $totalDonationsAmount = $donations->sum('amount');
        $averageDonationAmount = $totalDonations > 0 ? $totalDonationsAmount / $totalDonations : 0;

        $donationsToCampaigns = DonationToCampaign::where('type', 'مالي')->whereBetween('created_at', [$date_1, $date_2])->get();
        $totalDonationsToCampaigns = $donationsToCampaigns->count();
        $totalDonationsAmountToCampaigns = $donationsToCampaigns->sum('amount');
        $averageDonationAmountToCampaigns = $totalDonationsToCampaigns > 0 ? $totalDonationsAmountToCampaigns / $totalDonationsToCampaigns : 0;

        return  response()->json([
            'Total Donations count' => $totalDonations,
            'Total Donations amount' => $totalDonationsAmount,
            'Average Donation amount' => $averageDonationAmount,
            'Total Donations count to campaigns' => $totalDonationsToCampaigns,
            'Total Donations amount to campaigns' => $totalDonationsAmountToCampaigns,
            'Average Donation amount to campaigns' => $averageDonationAmountToCampaigns,
        ], 200);
    }

    public function InkindDonations()
    {
        // TODO: Implement inkind donations statistics
    }
    public function campaigns()
    {
        $campaigns = Campaign::all();
        $campaign_count = $campaigns->count();
        $number_of_Beneficiary_from_campaign = $campaigns->sum('number_of_Beneficiary');
        $total_cost_of_all_campaign = $campaigns->sum('cost');
    }

    public function donationsByCampaign(Request $request)
    {
        // TODO: Implement donations statistics by campaign
    }
}
