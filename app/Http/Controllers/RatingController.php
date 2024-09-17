<?php

	namespace App\Http\Controllers;

	use App\Models\Rating;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

	class RatingController extends Controller
	{
		public function store(Request $request)
		{
			// Validate the incoming request
			$validated = $request->validate([
				'freelancer_id' => 'required|exists:users,id',
				'service_id' => 'required|exists:services,id',
				'rating' => 'required|integer|between:1,5',
				'comments' => 'required|string'
			]);

			$userId = Auth::id();
			$freelancerId = $validated['freelancer_id'];
			$serviceId = $validated['service_id'];

			// Prevent users from rating themselves
			if ($userId == $freelancerId) {
				return redirect()->back()->with('error', 'You cannot rate yourself.');
			}

			// Check if the user has already rated this freelancer for the specific service
			$existingRating = Rating::where('user_id', $userId)
				->where('freelancer_id', $freelancerId)
				->where('service_id', $serviceId)
				->first();

			if ($existingRating) {
				return redirect()->back()->with('error', 'You have already rated this service for this freelancer.');
			}

			// Create a new rating record
			Rating::create([
				'user_id' => $userId,
				'freelancer_id' => $freelancerId,
				'service_id' => $serviceId, // Ensure service_id is included here
				'rating' => $validated['rating'],
				'comments' => $validated['comments'] ?? null
			]);

			return redirect()->back()->with('success', 'Rating submitted successfully!');
		}


	}
