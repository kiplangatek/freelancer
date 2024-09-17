<?php

	namespace App\Http\Controllers;

	use App\Mail\AccountSuspended;
use App\Mail\CreateService;
use App\Mail\Verification;
use App\Models\Category;
use App\Models\Rating;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

	class AdminController extends Controller
	{
		public function index(Request $request)
		{
			$usertype = $request->query('usertype');

			// Query to fetch users based on usertype and exclude admins
			$query = User::query();

			if ($usertype) {
				$query->where('usertype', $usertype);
			}

			$users = $query->where('usertype', '!=', 'admin')->get();

			// Fetch all
			$ratings = Rating::all();
			$categories = Category::all();
			$services = Service::withCount('applications as active_applications_count')->get();

			// Fetch freelancers who haven't created any services
			$inactiveFreelancers = User::where('usertype', 'freelancer')
				->doesntHave('services')
				->get();

			return view('admin.reports', compact('users', 'ratings', 'categories', 'services', 'inactiveFreelancers'));
		}


		public function deleteUser($id): RedirectResponse
		{
			$user = User::findOrFail($id);
			$user->delete();

			return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
		}

		public function verify($id): RedirectResponse
		{
			$user = User::find($id);
			if ($user) {
				$user->verified = true;
				$user->save();

				// Send verification email
				Mail::to($user->email)->send(new Verification($user));

				return redirect()->route('admin.index')->with('success', 'User verified successfully.');
			}

			return redirect()->route('admin.index')->with('error', 'User not found.');
		}

		public function revoke($id): RedirectResponse
		{
			$user = User::find($id);
			$user->verified = false;
			$user->save();

			return redirect()->route('admin.index')->with('success', 'Freelancer verification revoked.');
		}

		public function suspend($id): RedirectResponse
		{
			$user = User::find($id);

			if (!$user) {
				return back()->withErrors(['error' => 'User not found.']);
			}

			// Toggle the suspension status
			$wasSuspended = $user->suspended;
			$user->suspended = !$user->suspended;
			$user->save();

			$status = $user->suspended ? 'suspended' : 'unsuspended';
			Mail::to($user->email)->send(new AccountSuspended($user, $status));

			$message = $user->suspended
				? 'User account has been suspended and notification sent.'
				: 'User account has been unsuspended and notification sent.';

			return back()->with('message', $message);
		}

		public function createService()
		{
			$inactiveFreelancers = User::where('usertype', 'freelancer')
				->doesntHave('services')
				->get();

			foreach ($inactiveFreelancers as $freelancer) {
				Mail::to($freelancer->email)->send(new CreateService($freelancer));
			}

			return redirect()->back()->with('success', 'Notification emails have been sent to all inactive freelancers.');
		}


	}
