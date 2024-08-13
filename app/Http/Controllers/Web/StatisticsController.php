<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\DonationToCampaign;
use App\Models\Employee;
use App\Models\Section;
use App\Models\Volunteer;
use App\Models\VolunteerInCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function sectionAndEmployee()
    {
        $sections = Section::withCount('employee')->get();
        return $sections;
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

    public function financialDonationsByDay(Request $request)
    {
        $date_1 = $request->input('first_date');
        $date_2 = $request->input('second_date');

        // Fetch donations within the specified date range and group by day
        $donations = Donation::where('type', 'مالي')
            ->whereBetween('created_at', [$date_1, $date_2])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('date')
            ->get();

        // Process donations data
        $donationsData = $donations->map(function ($item) {
            return [
                'date' => $item->date,
                'total_donations' => $item->count,
                'total_amount' => $item->total_amount,
                'average_amount' => $item->count > 0 ? $item->total_amount / $item->count : 0,
            ];
        });

        // Fetch donations to campaigns within the specified date range and group by day
        $donationsToCampaigns = DonationToCampaign::where('type', 'مالي')
            ->whereBetween('created_at', [$date_1, $date_2])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('date')
            ->get();

        // Process donations to campaigns data
        $donationsToCampaignsData = $donationsToCampaigns->map(function ($item) {
            return [
                'date' => $item->date,
                'total_donations_to_campaigns' => $item->count,
                'total_amount_to_campaigns' => $item->total_amount,
                'average_amount_to_campaigns' => $item->count > 0 ? $item->total_amount / $item->count : 0,
            ];
        });

        return response()->json([
            'Donations by day' => $donationsData,
            'Donations to campaigns by day' => $donationsToCampaignsData,
        ], 200);
    }

    public function financialDonationsByWeek(Request $request)
    {
        $date_1 = $request->input('first_date');
        $date_2 = $request->input('second_date');

        // Fetch donations within the specified date range and group by week
        $donations = Donation::where('type', 'مالي')
            ->whereBetween('created_at', [$date_1, $date_2])
            ->select(DB::raw('WEEK(created_at) as week'), DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('week')
            ->get();

        // Process donations data
        $donationsData = $donations->map(function ($item) {
            return [
                'week' => $item->week,
                'total_donations' => $item->count,
                'total_amount' => $item->total_amount,
                'average_amount' => $item->count > 0 ? $item->total_amount / $item->count : 0,
            ];
        });

        // Fetch donations to campaigns within the specified date range and group by week
        $donationsToCampaigns = DonationToCampaign::where('type', 'مالي')
            ->whereBetween('created_at', [$date_1, $date_2])
            ->select(DB::raw('WEEK(created_at) as week'), DB::raw('count(*) as count'), DB::raw('sum(amount) as total_amount'))
            ->groupBy('week')
            ->get();

        // Process donations to campaigns data
        $donationsToCampaignsData = $donationsToCampaigns->map(function ($item) {
            return [
                'week' => $item->week,
                'total_donations_to_campaigns' => $item->count,
                'total_amount_to_campaigns' => $item->total_amount,
                'average_amount_to_campaigns' => $item->count > 0 ? $item->total_amount / $item->count : 0,
            ];
        });

        return response()->json([
            'Donations by week' => $donationsData,
            'Donations to campaigns by week' => $donationsToCampaignsData,
        ], 200);
    }

    public function InkindDonations()
    {
        // TODO: Implement inkind donations statistics
    }
    public function campaigns(Request $request)
    {
        $year = $request->input('year');
        $campaigns = Campaign::whereYear('created_at', $year);
        $campaign_count = $campaigns->count();
        $number_of_beneficiary_from_campaign = $campaigns->sum('number_of_Beneficiary');
        $total_cost_of_all_campaign = $campaigns->sum('cost');

        return response()->json([
            'Number of campaigns' => $campaign_count,
            'Number of beneficiaries from campaigns' => $number_of_beneficiary_from_campaign,
            'Total cost of all campaigns' => $total_cost_of_all_campaign,
        ], 200);
    }

    public function donationsByCampaign(Request $request)
    {
        // TODO: Implement donations statistics by campaign
    }
}
