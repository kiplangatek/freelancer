<?php

	namespace App\Http\Controllers;

	use App\Models\Rating;
	use App\Models\Service;
	use App\Models\Application;
	use App\Models\User;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\DB;
	use Request;
	use Illuminate\Support\Facades\Log;
	use Carbon\Carbon;

	// Correct import

	class FreelancerDashboardController extends Controller
	{
		public function index()
		{
			$user = Auth::user();
			return view('freelancer.index', compact('user'));
		}

		public function creator()
		{
			// Get all users who are of type 'freelancer' and have services
			$freelancers = User::where('usertype', 'freelancer')
				->whereIn('id', function ($query) {
					$query->select('id')
						->from('users')
						->distinct();
				})
				->get();

			// Calculate average ratings for each freelancer
			foreach ($freelancers as $freelancer) {
				// Get all ratings for this freelancer
				$ratings = Rating::where('freelancer_id', $freelancer->id)->get();


				// Calculate average rating
				$averageRating = $ratings->avg('rating');

				// If there are no ratings, set the average to 0.0
				$freelancer->averageRating = $averageRating ? number_format($averageRating, 1) : '0.0';
			}

			// Pass freelancers data to the view
			return view('creators', compact('freelancers'));
		}


		public function getAnalysis(Request $request)
		{
			try {
				$user = Auth::user();
				$freelancerId = $user->id;

				// General data for all users
				$applications = Application::where('applicant_id', $user->id)->count();

				$completedRequests = Application::where('freelancer_id', $freelancerId)
					->where('status', 1)
					->where('client_status', 1)
					->count();

				$myCompletedRequests = Application::where('applicant_id', $user->id)
					->where('status', 1)
					->where('client_status', 1)
					->count();

				$mySpend = DB::table('services')
					->join('applications', 'services.id', '=', 'applications.service_id')
					->where('applications.applicant_id', $user->id)
					->where('applications.status', 1)
					->where('applications.client_status', 1)
					->sum('services.price');

				$serviceCount = Service::where('freelancer_id', $freelancerId)->count();
				$requestCount = Application::where('freelancer_id', $freelancerId)->count();

				$totalEarnings = DB::table('services')
					->leftJoin('applications', 'services.id', '=', 'applications.service_id')
					->where('services.freelancer_id', $freelancerId)
					->where('applications.status', 1)
					->where('applications.client_status', 1)
					->sum('services.price');

				$totalEarningsWithDeduction = round($totalEarnings * 0.90, 2);

				// Earnings grouped by YYYY-MM (SQLite strftime)
				$monthlyEarnings = Application::where('applications.freelancer_id', $freelancerId)
					->where('applications.status', 1)
					->where('applications.client_status', 1)
					->whereNotNull('applications.updated_at')
					->leftJoin('services', 'applications.service_id', '=', 'services.id')
					->selectRaw("strftime('%Y-%m', applications.updated_at) as period, SUM(services.price) as earnings")
					->groupByRaw("strftime('%Y-%m', applications.updated_at)")
					->pluck('earnings', 'period')
					->toArray();

				// Normalize with deduction
				$earningsPerMonth = [];
				foreach ($monthlyEarnings as $period => $earnings) {
					$earningsPerMonth[$period] = round($earnings * 0.90, 2);
				}

				// Current + previous month (YYYY-MM format)
				$currentMonth = Carbon::now()->format('Y-m');
				$previousMonth = Carbon::now()->subMonth()->format('Y-m');

				$currentMonthEarnings = $earningsPerMonth[$currentMonth] ?? 0;
				$previousMonthEarnings = $earningsPerMonth[$previousMonth] ?? 0;

				if ($previousMonthEarnings == 0) {
					$percentageChange = $currentMonthEarnings > 0 ? 100 : 0;
				} else {
					$percentageChange = (($currentMonthEarnings - $previousMonthEarnings) / $previousMonthEarnings) * 100;
				}

				// Average monthly spend since registration
				$registrationDate = $user->created_at;
				$monthsFromRegistration = max(1, $registrationDate->diffInMonths(now()));
				$averageSpending = round($mySpend / $monthsFromRegistration, 1);

				return response()->json([
					'serviceCount' => $serviceCount,
					'applications' => $applications,
					'requestCount' => $requestCount,
					'mySpend' => $mySpend,
					'completedRequests' => $completedRequests,
					'myCompletedRequests' => $myCompletedRequests,
					'totalEarnings' => $totalEarningsWithDeduction,
					'currentMonthEarnings'=>$currentMonthEarnings,
					'monthlyEarnings' => $earningsPerMonth, // keyed by YYYY-MM
					'averageSpending' => $averageSpending,
					'percentageChange' => round($percentageChange, 0),
				]);

			} catch (\Exception $e) {
				Log::error('Error in getAnalysis method:', ['error' => $e->getMessage()]);
				return response()->json(['error' => 'Unable to fetch analysis data'], 500);
			}
		}


	}

