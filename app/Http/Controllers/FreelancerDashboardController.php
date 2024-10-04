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


				$currentMonth = Carbon::now()->format('m');
				$previousMonth = Carbon::now()->subMonth()->format('m');


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

				// Using strftime for SQLite or a similar database
				$monthlyEarnings = Application::where('applications.freelancer_id', $freelancerId)
					->where('applications.status', 1)
					->where('applications.client_status', 1)
					->selectRaw("strftime('%m', applications.updated_at) as month, SUM(services.price) as earnings")
					->leftJoin('services', 'applications.service_id', '=', 'services.id')
					->groupByRaw("strftime('%m', applications.updated_at)")
					->pluck('earnings', 'month')->toArray();


				$earningsPerMonth = array_fill(1, 12, 0); // Initialize 1 through 12 for each month
				foreach ($monthlyEarnings as $month => $earnings) {
					$earningsPerMonth[(int)$month] = round($earnings * 0.90, 2); // Apply 10% deduction
				}

				$registrationDate = $user->created_at;
				$now = now();
				// Calculate the number of months since registration
				$monthsFromRegistration = max(1, $registrationDate->diffInMonths($now)); // Avoid division by zero
				// Round up months from registration
				$monthsFromRegistration = ceil($monthsFromRegistration);
				// Calculate the average spending
				$averageSpending = round($mySpend / $monthsFromRegistration, 1);

				// Log the values
				Log::info('Months From Registration: ' . $monthsFromRegistration);
				Log::info('Average Spending: ' . $averageSpending);


				// Get current and previous month earnings
				$currentMonthEarnings = isset($monthlyEarnings[$currentMonth]) ? $monthlyEarnings[$currentMonth] : 0;
				$previousMonthEarnings = isset($monthlyEarnings[$previousMonth]) ? $monthlyEarnings[$previousMonth] : 0;

				if ($previousMonthEarnings == 0) {
					$percentageChange = $currentMonthEarnings > 0 ? 100 : 0;
				} else {
					$percentageChange = (($currentMonthEarnings - $previousMonthEarnings) / $previousMonthEarnings) * 100;
				}

				// Log the percentage change
				Log::info('Percentage change in earnings: ' . $percentageChange . '%');

				return response()->json([
					'serviceCount' => $serviceCount,
					'applications' => $applications,
					'requestCount' => $requestCount,
					'mySpend' => $mySpend,
					'completedRequests' => $completedRequests,
					'myCompletedRequests' => $myCompletedRequests,
					'totalEarnings' => $totalEarningsWithDeduction,
					'monthlyEarnings' => $earningsPerMonth,
					'averageSpending' => $averageSpending,
					'percentageChange' => round($percentageChange, 2),  // Ensure it's passed correctly
				]);


			} catch (\Exception $e) {
				// Log any exception that occurs during the execution
				Log::error('Error in getAnalysis method:', ['error' => $e->getMessage()]);
				return response()->json(['error' => 'Unable to fetch analysis data'], 500);
			}
		}


	}

