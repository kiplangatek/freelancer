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
	<script src="https:cdn.tailwindcss.com"></script>
	<title>Services by {{ $freelancer->name }}</title>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="h-full bg-gray-400 font-inter">
@auth()
	@php
		$userId = Auth::id();
		$isAdmin = Auth::user()->usertype ==='admin';
		$hasRated = $freelancer->ratings->contains('user_id', $userId);
		$isSelf = $freelancer->id == $userId;
		$hasService = $freelancer->services()->exists();
	@endphp
@endauth
<x-header></x-header>
<section class="body-font mt-14 bg-gray-400 px-3 py-10 text-gray-600">
	<nav class="mb-5 flex items-center">
		<ol class="list-reset flex items-center text-lg text-gray-700">
			<li>
				<a href="{{ route('services.index') }}" class="text-blue-600 hover:text-blue-800">Home</a>
			</li>
			<li class="flex items-center">
				<ion-icon name="chevron-forward-outline"></ion-icon>
				<a href="{{ route('freelancer.services', $freelancer->id) }}"
				   class="text-blue-600 hover:text-blue-800">
					{{ $freelancer->name }}
				</a>
			</li>
			<li class="justify-content-center flex items-center">
				<ion-icon name="chevron-forward-outline"></ion-icon>
				<span>Services</span>
			</li>
		</ol>
	</nav>

	<div class="container mx-auto">
		<div class="mb-4 text-center">
			<img width="70px" height="70px" class="mx-auto mb-2 h-20 w-20 rounded-full"
			     src="{{ asset('storage/avatars/' . $freelancer->photo) }}" alt="{{ $freelancer->name }}">
			<div class="items center mx-auto flex w-full items-center justify-center">
				<h1 class="text-2xl font-semibold">
					{{ $freelancer->name }}
				</h1>
				@if ($freelancer->verified == true)
					<img width="20px" src="{{ asset('storage/ui/verified.png') }}" alt="verified"/>
				@endif
			</div>
			<p class="text-lg text-gray-600">{{ $freelancer->email }}</p>
		</div>
		<!-- Services List -->
		<div class="mx-auto grid grid-cols-1 gap-0.5 md:grid-cols-2 md:gap-6 lg:grid-cols-2 xl:grid-cols-2">
			@forelse($services as $service)
				<div class="p-4">
					<div class="overflow-hidden rounded-lg bg-gray-100 shadow-lg">
						<div class="h-[150px] w-full bg-red-100 md:h-[200px] lg:max-h-60">
							<img class="h-full w-full object-cover"
							     src="{{ asset('storage/services/' . $service->image) }}"
							     alt="{{ $service->title }}">
						</div>
						<div class="px-2 py-4">
							<div class="flex justify-between">
								<h3 class="text-[13px] font-semibold text-gray-700 md:text-sm md:font-medium">
									{{ $service->title }}</h3>
								<span
									class="inline-block bg-green-300 rounded-md p-1 text-sm text-gray-500">Ksh. {{ number_format($service->price) }}</span>
							</div>
							<div class="mt-4 flex items-center justify-between">
								<a href="{{ route('services.show', $service->id) }}"
								   class="duration-600 inline-block flex-1 rounded-lg bg-blue-500 px-4 py-2 text-center text-white transition-all hover:bg-blue-800 hover:outline-none hover:ring-1 hover:ring-blue-900">
									View Service
								</a>
							</div>
						</div>
					</div>
				</div>
			@empty
				<p class="text-center text-gray-600">No services found for this freelancer.</p>
			@endforelse
		</div>

		<!-- Pagination -->
		<div class="mt-4">
			{{ $services->links() }} <!-- Pagination links -->
		</div>
	</div>
	<div id="ratingModal"
	     class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50 p-2">
		<div class="w-full max-w-md rounded-lg bg-gray-300 p-6 shadow-lg">
			<div class="mb-4 flex items-center justify-between">
				<h5 class="text-lg font-bold">Rate This Freelancer</h5>
				<button type="button" class="text-2xl text-gray-500 hover:text-gray-700"
				        onclick="closeRatingModal()">
					<ion-icon name="close"></ion-icon>
				</button>
			</div>
			<form id="ratingForm" action="{{ route('ratings.store') }}" method="POST">
				@csrf
				<!-- Hidden fields for freelancer_id and user_id -->
				<input type="hidden" name="freelancer_id" id="freelancer_id">
				<input type="hidden" name="user_id" value="{{ Auth::id() }}">

				<!-- Rating input -->
				<div class="mb-4">

					<label for="service_id" class="mb-2 block font-medium text-gray-700">Select Service:</label>
					<select name="service_id" id="service_id"
					        class="form-select mt-1 block h-8 w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
					        required>
						<option value="" disabled selected>Select a service</option>
						@foreach ($freelancer->services as $service)
							<option value="{{ $service->id }}">{{ $service->title }}</option>
						@endforeach
					</select>

					<label for="rating" class="mb-2 block font-medium text-gray-700">Rating (1-5):</label>
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
					<label for="comments" class="mb-2 block font-medium text-gray-700">Comments:</label>
					<textarea name="comments" id="comments"
					          class="form-textarea mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
					          rows="4" required></textarea>
				</div>

				<!-- Submit button -->
				<button type="submit" class="rounded bg-blue-950 px-4 py-2 text-white hover:bg-blue-600">
					Submit Rating
				</button>
			</form>
		</div>
	</div>
	@auth
		@if (!$hasRated && !$isSelf && $hasService && !$isAdmin)
			<!-- Button to open the rating modal -->
			<button type="button"
			        class="fixed bottom-3 right-3 rounded bg-blue-500 px-4 py-2 text-white hover:bg-blue-600"
			        onclick="openRatingModal({{ $freelancer->id }})">
				Rate Me
			</button>
		@endif
	@endauth

	@if ($freelancer->ratings->isNotEmpty())
		<div class="mt-6 px-4">
			<h2 class="mb-2 text-xl font-semibold">Ratings and Comments</h2>
			<p class="mb-2.5 ml-2.5 text-lg font-bold">
				@if ($averageRating)
					{{ number_format($averageRating, 1) }} / 5
					<span class="text-yellow-500">
                        @php
	                        $roundedRating = round($averageRating * 2) / 2; // Round to the nearest half star
                        @endphp
						@for ($i = 1; $i <= 5; $i++)
							@if ($i <= floor($roundedRating))
								<ion-icon name="star"></ion-icon>
							@elseif ($i == ceil($roundedRating) && $roundedRating - floor($roundedRating) > 0)
								<ion-icon name="star-half-outline"></ion-icon>
							@else
								<ion-icon name="star-outline"></ion-icon>
							@endif
						@endfor
                     </span>
				@endif
			</p>
			@foreach ($freelancer->ratings as $rating)
				@php
					$ratingValue = $rating->rating;
					$backgroundClass = '';

					if ($ratingValue >= 4) {
					    $backgroundClass = 'bg-green-100';
					} elseif ($ratingValue == 3) {
					    $backgroundClass = 'bg-gray-300';
					} else {
					    $backgroundClass = 'bg-red-100';
					}
				@endphp

				<div class="{{ $backgroundClass }} mb-4 rounded-xl p-4 shadow">
					<div class="mb-2 flex items-center">
						<!-- Display user image -->
						<img
							src="{{ asset('storage/avatars/' . $rating->user->photo) ?? 'https://via.placeholder.com/40' }}"
							alt="{{ $rating->user->name ?? 'User' }}"
							class="mr-3 h-8 w-8 rounded-full object-cover">
						<div>
                           <span class="font-bold">
                              {{ $rating->user->name ?? 'Unknown' }}
                           </span>
							<span class="ml-2 text-yellow-500">
                              @php
	                              $roundedRating = round($ratingValue * 2) / 2; // Round to the nearest half star
                              @endphp
								@for ($i = 1; $i <= 5; $i++)
									@if ($i <= floor($roundedRating))
										<ion-icon name="star"></ion-icon>
									@elseif ($i == ceil($roundedRating) && $roundedRating - floor($roundedRating) > 0)
										<ion-icon name="star-half-outline"></ion-icon>
									@else
										<ion-icon name="star-outline"></ion-icon>
									@endif
								@endfor
                           </span>
						</div>
					</div>

					<p class="font-bold italic text-gray-700">{{ $rating->service->title }}</p>
					<p class="text-sm text-gray-700">{{ $rating->comments }}</p>
					<p class="text-sm text-gray-500 italic">{{ $rating->created_at->format('M d, Y, H:i') }}</p>
				</div>
			@endforeach

		</div>
	@else
		<p class="text-gray-500">No ratings yet.</p>
	@endif

</section>
<x-footer></x-footer>
<x-scripts></x-scripts>
<script>
	function openRatingModal(freelancerId) {
		// Set the freelancer_id in the hidden input
		document.getElementById('freelancer_id').value = freelancerId;

		// Show the modal
		document.getElementById('ratingModal').classList.remove('hidden');
	}

	function closeRatingModal() {
		// Hide the modal
		document.getElementById('ratingModal').classList.add('hidden');
	}
</script>
</body>

</html>
