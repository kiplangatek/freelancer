@php use App\Models\Rating @endphp

	<!doctype html>
<html lang="en" data-bs-theme-mode="system">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		 content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">

	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<title>Services by {{ $application->service->title}}</title>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<script src="https://unpkg.com/alpinejs" defer></script>
</head>

<body class="h-full bg-gray-200/70 font-inter">
<section class="body-font w-full items-center px-4 pt-5 pb-28">

	<nav class="mb-5 flex items-center px-3 bg-white rounded-lg shadow w-full py-3">
		<ol class="list-reset flex items-center text-base text-gray-600">
			<li>
				<a href="/my" class="text-gray-500 hover:text-gray-700 flex items-center">
					<ion-icon name="home-outline" class="text-xl mr-1"></ion-icon>
				</a>
			</li>
			<li class="flex items-center">
				<ion-icon name="chevron-forward-outline" class="text-gray-400 mx-1"></ion-icon>
				<ion-icon name="document-text" class="text-gray-600 hover:text-gray-800"></ion-icon>
			</li>
			<li class="flex items-center">
				<ion-icon name="chevron-forward-outline" class="text-gray-400 mx-1"></ion-icon>
				<span class="text-gray-700">{{ $application->service->title }}</span>
			</li>
		</ol>

		<div class="ml-auto self-end">
			@php
				$statusIcon = '';
				$statusClass = '';
				$statusText = '';

				if ($application->status && $application->client_status) {
				    $statusIcon = 'checkmark-done-circle'; // Completed
				    $statusClass = 'bg-green-100/50 text-green-800';
				    $statusText = 'Completed';
				} elseif ($application->status || $application->client_status) {
				    $statusIcon = 'hourglass'; // In Progress
				    $statusClass = 'bg-yellow-50 text-yellow-800';
				    $statusText = 'In Progress';
				} else {
				    $statusIcon = 'timer'; // Pending
				    $statusClass = 'bg-yellow-50 text-yellow-800';
				    $statusText = 'Pending';
				}
			@endphp

			<div class="{{ $statusClass }} flex items-center justify-center rounded-full p-1.5 text-base font-bold h-9 w-9 md:w-auto">
				<ion-icon class="font-bold" name="{{ $statusIcon }}" size="large"></ion-icon>
				<!-- Show status text only on medium to large screens -->
				<span class="hidden md:inline ml-2 text-sm">{{ $statusText }}</span>
			</div>
		</div>
	</nav>

	<!-- Status Messages -->
	<div class="px-2 ">
		@if (session('success'))
			<x-alert type="success" :message="session('success')" />
		@endif
		@if (session('error'))
			<x-alert type="error" :message="session('error')" />
		@endif
	</div>
	<div class="container mx-auto mt-5">
		<!-- Freelancer Name and Service Price -->
		<div class="mb-2 flex items-center justify-between">
			<p class="text-lg font-black text-gray-900">
				{{ $application->service->freelancer->name ?? 'No Freelancer' }}
			</p>
			<p class="rounded-md bg-green-100 px-2 py-1 text-lg text-gray-600 shadow-sm">
				Ksh. {{ number_format($application->service->price) }}
			</p>
		</div>
		<!-- Service Image -->
		<div class="mb-3">
			@if ($application->service->image)
				<img src="{{ asset('storage/services/' . $application->service->image) }}" alt="Service Image"
					class="h-48 w-full rounded-md object-cover shadow-lg">
			@else
				<p class="italic text-gray-500">No Image Available</p>
			@endif
		</div>

		<!-- Service Details -->
		<div class="bg-trasparent px-4 py-6 leading-relaxed text-gray-950">
			{!! $application->service->details !!}
		</div>
		<!-- Actions Section -->

		@auth()
			@php
				$userId = Auth::user()->id;
					$isAdmin = Auth::user()->usertype === 'admin';
					$hasRated = Rating::where('application_id', $application->id)
					    ->where('user_id', $userId)
					    ->exists();
			@endphp
		@endauth
		<div class="mt-6 flex items-center justify-start">
			@if (!$application->status)
				<form action="{{ route('applications.cancel', $application->id) }}" method="POST"
					 onsubmit="return confirm('Are you sure you want to cancel this application?');">
					@csrf
					@method('DELETE')
					<button type="submit"
						   class="w-full rounded-md bg-red-600 px-4 py-2 text-white shadow-lg transition duration-300 hover:bg-red-700">
						Cancel Application
					</button>
				</form>
			@endif
			@if($application->status && !$application->client_status)
				<!-- Approve Button -->
				<button type="button" onclick="openModal()" class="w-full rounded-md bg-green-600 px-4 py-2 text-white shadow-lg transition duration-300
				hover:bg-green-700">
					Approve Completion
				</button>

				<!-- Modal HTML -->
				<div id="approveModal"
					class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 px-4">
					<div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
						<h2 class="text-xl font-semibold mb-4">Confirm Approval</h2>
						<p>Are you sure the request is complete? This action cannot be undone, and we are not
							liable for any further actions.</p>

						<div class="mt-6 flex justify-end space-x-4">
							<!-- Cancel Button -->
							<button type="button" onclick="closeModal()"
								   class="rounded-md bg-gray-300 px-4 py-2 text-black hover:bg-gray-400">
								Cancel
							</button>

							<!-- Confirm Button -->
							<form action="{{ route('applications.approve', $application->id) }}" method="POST"
								 class="inline">
								@csrf
								@method('PATCH')
								<button type="submit"
									   class="rounded-md bg-green-600 px-4 py-2 text-white hover:bg-green-700">
									Confirm
								</button>
							</form>
						</div>
					</div>
				</div>

				<script>
					function openModal() {
						document.getElementById('approveModal').classList.remove('hidden')
					}

					function closeModal() {
						document.getElementById('approveModal').classList.add('hidden')
					}
				</script>
			@endif
			@if($application->client_status)
				<div id="ratingModal"
					class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50 p-3">
					<div class="w-full max-w-md rounded-lg bg-gray-300 p-6 shadow-lg">
						<div class="mb-4 flex items-center justify-between">
							<h5 class="text-lg font-bold">Rate this Service Delivery</h5>
							<button type="button" class="text-2xl text-gray-500 hover:text-gray-700"
								   onclick="closeRatingModal()">
								<ion-icon name="close"></ion-icon>
							</button>
						</div>
						<form id="ratingForm" action="{{ route('ratings.store') }}" method="POST">
							@csrf
							<input type="hidden" name="freelancer_id" id="freelancer_id">
							<input type="hidden" name="user_id" value="{{ Auth::id() }}">
							<input type="hidden" name="application_id" value="{{$application->id}}">

							<!-- Rating input -->
							<div class="mb-4">

								<label for="service_title"
									  class="mb-2 block font-medium text-gray-700">Service:</label>

								<!-- Hidden input for service_id -->
								<input type="hidden" name="service_id" id="service_id"
									  value="{{ $application->service->id }}">

								<!-- Readonly input for displaying the service title -->
								<input
									class="outline-0 border-0 flex items-center mt-1 h-8 w-full rounded-md border-gray-300 bg-gray-100 px-3 py-2"
									type="text"
									readonly
									value="{{ $application->service->title }}">


								<label for="rating" class="mb-2 block font-medium text-gray-700">Rating
									(1-5):</label>
								<select name="rating" id="rating"
									   class="form-select mt-1 block h-8 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
									   required>
									<option value="" disabled selected>Select a rating</option>
									<option value="1">1 Star</option>
									<option value="2">2 Stars</option>
									<option value="3">3 Stars</option>
									<option value="4">4 Stars</option>
									<option value="5">5 Stars</option>
								</select>
							</div>

							<!-- Comments input -->
							<div class="mb-4">
								<label for="comments"
									  class="mb-2 block font-medium text-gray-700">Comments:</label>
								<textarea name="comments" id="comments"
										class="form-textarea mt-1 block p-2 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
										rows="4" required></textarea>
							</div>

							<!-- Submit button -->
							<button type="submit"
								   class="rounded bg-blue-950 px-4 py-2 text-white hover:bg-blue-600">
								Submit Rating
							</button>
						</form>
					</div>
				</div>
				@if (!$hasRated && !$isAdmin)
					<!-- Button to open the rating modal -->
					<button type="button"
						   class="rounded-xl bg-blue-500 px- py-3 text-white hover:bg-blue-600 w-4/5 mx-auto"
						   onclick="openRatingModal({{ $freelancer->id }})">
						Rate
					</button>
				@endif
			@endif
		</div>
	</div>
	<a href="/chat/{{$application->freelancer_id}}"
	   class="rounded-xl px-2 shadow-xl py-2.5 text-sm font-semibold text-gray-100 bg-teal-700 fixed right-3 bottom-3 flex items-center">Chat
		<ion-icon name="paper-plane" class="ml-1"></ion-icon>
	</a>
</section>

<script>
	function openRatingModal(freelancerId) {
		// Set the freelancer_id in the hidden input
		document.getElementById('freelancer_id').value = freelancerId

		// Show the modal
		document.getElementById('ratingModal').classList.remove('hidden')
	}

	function closeRatingModal() {
		// Hide the modal
		document.getElementById('ratingModal').classList.add('hidden')
	}
</script>
</body>
</html>
