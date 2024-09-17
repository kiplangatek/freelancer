<?php

	namespace App\Http\Controllers;

	use App\Models\Application;
	use App\Models\Category;
	use App\Models\Rating;
	use App\Models\Service;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Log;

	class ServiceController extends Controller
	{
		public function index(Request $request)
		{
			$categoryId = $request->input('category');

			$services = Service::query();

			if ($categoryId) {
				$services->where('category_id', $categoryId)->orderBy('created_at', 'desc');
			}

			// Use paginate() to get the total count
			$services = $services->orderBy('created_at', 'desc')->paginate(3)->appends(['category' => $categoryId]);

			$categories = Category::all();

			// Get total count of filtered services
			$totalCount = $services->total();

			return view('services.index', compact('services', 'categories', 'totalCount'));
		}

		public function services($id)
		{
			// Fetch the freelancer by ID with their ratings and services
			$freelancer = User::with('ratings', 'services')->findOrFail($id);

			// Calculate the average rating
			$averageRating = $freelancer->averageRating();

			// Fetch services associated with this freelancer, paginated
			$services = $freelancer->services()->latest()->paginate(3);

			// Pass the freelancer, services, and average rating to the view
			return view('freelancer.services', compact('freelancer', 'services', 'averageRating'));
		}

		public function show(Service $service)
		{
			// Retrieve the freelancer ID from the service
			$freelancerId = $service->freelancer_id;

			// Pass service and freelancerId to the view
			return view('services.show', compact('service', 'freelancerId'));
		}

		public function my(Service $service, Application $application)
		{
			$user = Auth::user();
			$userId = Auth::id();
			$ratings = Rating::where('freelancer_id', $userId)
				->avg('rating');
			$categories = Category::all();
			$averageRating = $ratings ? number_format($ratings, 1) : '0.0';
			$applications = Application::where('applicant_id', $user->id)
				->with('service')
				->orderBy('status', 'asc')
				->get();
			$services = Service::where('freelancer_id', $userId)->latest('id')->get();
			$activeApplications = Application::where('freelancer_id', Auth::id())
				->with(['service', 'applicant'])
				->orderBy('status', 'asc') // false (0) at the top, true (1) at the bottom
				->get();


			return view('profile.my', compact('services', 'activeApplications', 'categories', 'averageRating', 'applications'));
		}

		public function store(Request $request)
		{
			$request->validate([
				'title' => ['required', 'min:3'],
				'price' => ['required'],
				'details' => ['required'],
				'category_id' => ['required'],
				'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
			]);

			$details = $request->all();

			// Handle the photo upload
			if ($image = $request->file('image')) {
				$destinationPath = 'storage/services/';
				$profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
				$image->move($destinationPath, $profileImage);
				$details['image'] = $profileImage;
			}

			Service::create([
				'title' => $details['title'],
				'price' => $details['price'],
				'details' => $details['details'],
				'category_id' => $details['category_id'],
				'image' => $details['image'] ?? null,
				'freelancer_id' => Auth::id(),
			]);

			return redirect()->route('services.my')->with('success', 'Service created successfully.');
		}

		public function edit(Service $service)
		{
			return view('services.edit', ['service' => $service]);
		}

		public function feature($id)
		{
			$service = Service::find($id);
			if ($service) {
				$service->featured = true;
				$service->save();
			}
			return redirect()->route('admin.index', ['activeTab' => 'services']);
		}

		public function removeFeature($id)
		{
			$service = Service::find($id);
			if ($service) {
				$service->featured = false;
				$service->save();
			}
			return redirect()->route('admin.index', ['activeTab' => 'services']);
		}

		public function update(Service $service, Request $request)
		{
			// Validate the incoming request data
			$validatedData = $request->validate([
				'title' => ['nullable', 'min:3'],
				'price' => ['nullable'],
				'details' => ['nullable'],
				'image' => ['nullable', 'image'],
			]);

			// Initialize an empty array to hold the data to update
			$dataToUpdate = [];

			// Conditionally add each field to the update array if it's provided
			if (!empty($validatedData['title'])) {
				$dataToUpdate['title'] = $validatedData['title'];
			}

			if (!empty($validatedData['price'])) {
				$dataToUpdate['price'] = $validatedData['price'];
			}

			if (isset($validatedData['details'])) {
				$dataToUpdate['details'] = $validatedData['details'];
			}

			// Handle the photo upload if an image is provided
			if ($image = $request->file('image')) {
				$destinationPath = 'storage/services/';
				$newImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

				// Check if there is an existing image and delete it
				if ($service->image && file_exists(public_path($destinationPath . $service->image))) {
					unlink(public_path($destinationPath . $service->image));
				}

				// Move the new image to the storage
				$image->move($destinationPath, $newImage);
				$dataToUpdate['image'] = $newImage;
			}

			// Always update the freelancer_id to the currently authenticated user
			$dataToUpdate['freelancer_id'] = Auth::id();

			// Perform the update on the service model
			$service->update($dataToUpdate);;

			// Redirect the user back to the service page
			return redirect('/services/' . $service->id);
		}

		public function destroy(Service $service)
		{
			// Check if the service has any related applications
			if ($service->applications()->exists()) {
				$activeApplicationsCount = $service->applications()->count();
				$applicationText = $activeApplicationsCount === 1 ? 'application' : 'applications';

				return redirect()->back()->with('error', "Cannot delete $service->title because of  $activeApplicationsCount active $applicationText.");

			}

			// Delete the service if no related applications exist
			$service->delete();

			// Redirect to the services list with a success message
			return redirect()->back()->with('success', 'Service deleted successfully.');
		}

		public function search(Request $request)
		{
			$search = $request->search;
			$services = Service::where(function ($query) use ($search) {
				$query->where('title', 'like', "%$search%")
					->orWhere('details', 'like', "%$search%");
			})->orWhereHas('freelancer', function ($query) use ($search) {
				$query->where('name', 'like', "%$search%");
			})->paginate(5); // Add pagination here with a limit, e.g., 10 per page

			$categories = Category::all();
			$totalCount = $services->total();
			return view('services.index', compact('search', 'categories', 'totalCount', 'services'));
		}

	}
