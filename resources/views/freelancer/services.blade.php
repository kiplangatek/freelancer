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
	<title>Services by {{ $freelancer->name }}</title>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="h-full bg-gray-200/70 font-inter">
<x-header></x-header>
<section class="body-font mt-20 px-4 md:px-10 py-10 text-gray-600">
	<nav class="mb-5 flex items-center px-3 bg-white rounded-lg shadow w-fit py-3">
		<ol class="list-reset flex items-center text-lg text-gray-600">
			<li>
				<a href="{{ route('services.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center">
					<ion-icon name="library" class="text-2xl mr-1"></ion-icon>
				</a>
			</li>
			<li class="flex items-center">
				<ion-icon name="chevron-forward-outline" class="text-gray-400 mx-2"></ion-icon>
				<span class="text-gray-700">{{ $freelancer->name }}</span>
			</li>
		</ol>
	</nav>

	<div class=" mx-auto">

		<!-- Freelancer Info -->
		<div class="flex items-start bg-white rounded-lg shadow-lg p-4 md:p-6 mb-6 ">
			<div class="h24 w-24">
				<img class="h-24 w-full rounded-full mb-4"
					src="{{ asset('storage/avatars/' . $freelancer->photo) }}"
					alt="{{ $freelancer->name }}">
			</div>
			<div class="ml-3 flex-1">
				<div class="flex items-center">
					<h1 class="text-xl md:text-2xl font-bold uppercase ">{{ $freelancer->name }}</h1>
					@if ($freelancer->verified == true)
						<img class="h-5" src="{{ asset('storage/ui/verified.png') }}" alt="verified">
					@endif
				</div>
				<p class="text-sm text-gray-500 flex items-center mb-2">
					<ion-icon name="at"></ion-icon>{{ $freelancer->username }}</p>
				<div class="flex items-center justify-between">
					<p class="text-base md:text-lg font-semibold mb-3 flex items-center p-1 rounded-xl bg-blue-200 w-fit">
						<ion-icon name="star"
								class="text-yellow-600 text-lg mr-1"></ion-icon>{{ number_format($averageRating, 1) }}
						({{$allRatings}})
					</p>
					<a class="mb-3 rounded-lg bg-blue-200 text-grey-700 px-2 py-1 border border-blue-500 flex items-center"
					   href="/chat/{{$freelancer->id}}">
						<ion-icon name="mail-outline" class="mr-0.5"></ion-icon>
						Message</a>
				</div>
			</div>
		</div>
		<!-- Services List -->
		<div class="mx-auto grid grid-cols-1 md:grid-cols-2 gap-1 lg:grid-cols-3 xl:grid-cols-4">
			@forelse($services as $service)
				<div class="p-4">
					<div class="overflow-hidden rounded-lg bg-gray-100 shadow-lg">
						<div class="h-[150px] w-full bg-red-100 md:h-48">
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
				<p class="text-center text-gray-600">This user hasn't created any service.</p>
			@endforelse
		</div>

		<!-- Pagination -->
		<div class="mt-4">
			{{ $services->links() }} <!-- Pagination links -->
		</div>
	</div>

	@if ($freelancer->ratings->isNotEmpty())
		<div class="mt-4 px-4">
			<h2 class="mb-2 text-xl font-semibold">Ratings</h2>
			<div class="space-y-3">
				@foreach ($freelancer->ratings as $rating)
					@php
						$ratingValue = $rating->rating;
							 $ratingClass = $ratingValue >= 4 ? 'text-green-600' : ($ratingValue == 3 ? 'text-gray-600' : 'text-red-600');
					@endphp

					<div class="flex items-start p-2 border-b-2 last:border-b-0">
						<img
							src="{{ asset('storage/avatars/' . $rating->user->photo) ?? 'https://via.placeholder.com/40' }}"
							alt="{{ $rating->user->name ?? 'User' }}"
							class="mr-3 h-10 w-10 rounded-full object-cover">
						<div class="flex-1">
							<div class="flex justify-between items-center">
								<span class="font-semibold">{{ $rating->user->name ?? 'Unknown' }}</span>
								<span class="{{ $ratingClass }}">
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
							<p class="text-sm font-bold  text-gray-700">{{ $rating->service->title }}</p>
							<p class="text-sm text-gray-700">{{ $rating->comments }}</p>
							<p class="text-xs text-gray-500 italic">{{ $rating->created_at->format('M d, Y') }}</p>
						</div>
					</div>
				@endforeach
			</div>


		</div>
	@else
		<p class="text-gray-500">No ratings yet.</p>
	@endif

</section>
<x-footer></x-footer>
<x-scripts></x-scripts>
</body>

</html>
