<?php

	namespace App\Http\Controllers;

	use App\Mail\NewApplication;
	use App\Models\Application;
	use App\Models\Rating;
	use App\Models\Service;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Mail;

	class ApplicationController extends Controller
	{


//		public function index()
//		{
//			// Get the authenticated user
//			$user = Auth::user();
//			$userId = Auth::id();
//			// Calculate the average rating for the logged-in user
//			$ratings = Rating::where('user_id', $userId)->avg('rating');
//			$averageRating = $ratings ? number_format($ratings, 1) : '0.0';
//			$freelancerId = Auth::id();
//			$services = Service::where('freelancer_id', $userId)->latest('id')->get();
//			$applications = Application::where('applicant_id', $user->id)->with('service')->get();
//			$activeApplications = Application::where('freelancer_id', $freelancerId)->get();
//			// Return the view with applications
//			return view('profile.my', compact('applications', 'services', 'activeApplications', 'averageRating', 'freelancerId'));
//		}

		public function show($id)
		{
			// Fetch the application with the associated service and freelancer
			$application = Application::with(['service.freelancer'])->find($id);

			if (!$application) {
				abort(404); // or handle the case where the application is not found
			}

			// Get the freelancer from the service associated with the application
			$freelancer = $application->service->freelancer;


			// Pass application, freelancer, average rating, and ratings count to the view
			return view('applications.show', compact('application', 'freelancer'));
		}


		public function apply(Request $request)
		{
			// Validate the incoming request data
			$request->validate([
				'service_id' => 'required|exists:services,id',
			]);

			// Retrieve the service based on the service_id
			$service = Service::find($request->service_id);

			// Check if the freelancer who owns the service is suspended
			if ($service->freelancer->suspended) {
				return redirect()->back()->with('error', 'Cannot apply: the owner is currently suspended.');
			}
			// Create a new application record
			Application::create([
				'service_id' => $service->id,
				'applicant_id' => Auth::id(), // Get the ID of the authenticated user
				'freelancer_id' => $service->freelancer->id,
			]);

			Mail::to($service->freelancer->email)->send(new NewApplication($service));
			// Redirect with success message
			return redirect()->back()->with('success', 'Application submitted successfully!');
		}

		public function cancel(Application $application)
		{
			$application->delete();

			return redirect()->route('services.my')->with('status', 'Application cancelled successfully.');
		}

		public function complete($id)
		{
			$application = Application::findOrFail($id);
			// Toggle the status: if it's true (completed), set it to false (incomplete), and vice versa
			$application->status = !$application->status;
			$application->save();

			$message = $application->status ? 'Application status updated to complete!' : 'Application status updated to incomplete!';
			return redirect()->back()->with('success', $message);
		}


		public function approveCompleted($id)
		{
			$application = Application::findOrFail($id);
			$application->client_status = 1;
			$application->save();

			return redirect()->back()->with('success', 'Application approved successfully!,You can rate the delivery at the bottom');
		}

	}
