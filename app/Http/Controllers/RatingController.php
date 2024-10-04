<?php

	namespace App\Http\Controllers;

	use App\Models\Rating;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

	class RatingController extends Controller
	{
		public function store(Request $request)
		{
			// Log the incoming request data
			\Log::info('Incoming Rating Request:', $request->all());

			// Validate the incoming request
			$validated = $request->validate([
				'freelancer_id' => 'required|exists:users,id',
				'service_id' => 'required|exists:services,id',
				'application_id' => 'required|exists:applications,id',
				'rating' => 'required|integer|between:1,5',
				'comments' => 'required|string'
			]);

			$userId = Auth::id();
			$freelancerId = $validated['freelancer_id'];
			$serviceId = $validated['service_id'];
			$applicationId = $validated['application_id'];

			// Prevent users from rating themselves
			if ($userId == $freelancerId) {
				return redirect()->back()->with('error', 'You cannot rate yourself.');
			}

			// Check if the user has already rated the specific service
			$existingRating = Rating::where('application_id', $applicationId)
				->where('user_id', $userId)
				->first();

			if ($existingRating) {
				return redirect()->back()->with('error', 'You have already rated this service for this application.');
			}

			// Create a new rating record
			Rating::create([
				'user_id' => $userId,
				'freelancer_id' => $freelancerId,
				'service_id' => $serviceId, // Ensure service_id is included here
				'rating' => $validated['rating'],
				'comments' => $validated['comments'] ?? null,
				'application_id' => $applicationId,
			]);

			return redirect()->back()->with('success', 'Rating submitted successfully!');
		}


	}
