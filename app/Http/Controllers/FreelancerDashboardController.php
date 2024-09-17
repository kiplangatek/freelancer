<?php

	namespace App\Http\Controllers;

	use App\Models\Rating;
	use App\Models\User;
	use Illuminate\Support\Facades\Auth;

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

	}

