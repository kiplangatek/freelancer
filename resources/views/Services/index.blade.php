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
	<title>Services</title>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<!-- Alpine.js for Toggle -->
	<script src="//unpkg.com/alpinejs" defer></script>
	<style>
		/* Hide scrollbar for webkit browsers */
		.scrollbar-hidden::-webkit-scrollbar {
			display: none;
		}

		/* Hide scrollbar for Firefox */
		.scrollbar-hidden {
			-ms-overflow-style: none; /* IE and Edge */
			scrollbar-width: none; /* Firefox */
		}

		@keyframes pulse {
			0% {
				transform: scale(1);
				opacity: 1;
			}
			50% {
				transform: scale(1.1);
				opacity: 0.7;
			}
			100% {
				transform: scale(1);
				opacity: 1;
			}
		}

		.search-icon {
			animation: pulse 1.5s infinite;
		}

	</style>
</head>

<body class="h-full bg-gray-200 font-inter ">
<x-header></x-header>
<section class="body-font mb-8 mt-20 bg-gray-200 px-5 py-10 text-gray-600 md:px-10">

	@php
		// Get the selected category from the request
		$selectedCategory = $categories->firstWhere('id', request('category'));

		// Remove the selected category from the collection if it's present
		if ($selectedCategory) {
		    $categories = $categories->filter(function ($category) {
			   return $category->id != request('category');
		    });
		}
	@endphp

	<div class="flex overflow-x-auto whitespace-nowrap py-2 space-x-0.5 scrollbar-hidden">
		<a href="{{ route('services.index') }}"
		   class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-900 focus:text-blue-500 focus:outline-none {{ request('category') ? '' : 'bg-blue-500 text-white rounded-t-3xl' }} rounded-3xl">
			All
		</a>

		@if($selectedCategory)
			<div class="flex items-center space-x-2 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-500 focus:text-blue-500 bg-blue-200 ring-1 focus:outline-blue-500 text-white rounded-3xl">
				<a href="{{ route('services.index', ['category' => $selectedCategory->id]) }}"
				   class="text-sm font-medium text-blue-500 hover:text-blue-600 focus:text-blue-600 focus:outline-none  text-blue-500 rounded-3xl">
					{{ $selectedCategory->name }}
				</a>
				<!-- Add an 'x' icon to reset using ion-icon -->
				<a href="{{ route('services.index') }}" class="text-gray-700 hover:text-red-500 flex items-center">
					<ion-icon name="close-outline" class="text-xl font-black"></ion-icon>
				</a>
			</div>
		@endif

		@foreach ($categories as $category)
			<a href="{{ route('services.index', ['category' => $category->id]) }}"
			   class="px-4 py-2 text-sm font-medium text-gray-500 hover:text-blue-500 focus:text-blue-500 focus:outline-none {{ request('category') == $category->id ? 'bg-blue-500 text-white rounded-3xl' : '' }} rounded-3xl">
				{{ $category->name }}
			</a>
		@endforeach
	</div>


	<!-- Display Count -->
	<div class="mb-4 text-gray-700 md:hidden">
		<!-- Filter Count Message -->
		@if ($totalCount > 0 && request('category'))
			<p class="block md:hidden bg-green-50 bg-opacity-50 border rounded-xl px-4 py-2 mt-1 shadow-md mb-4">
				Showing {{ $totalCount }} {{ $totalCount > 1 ? 'results' : 'result' }}
			</p>
		@endif
	</div>

	<div class="mx-auto grid grid-cols-1 gap-0.5 md:grid-cols-2 md:gap-1 lg:grid-cols-3">
		@if ($services->isEmpty())
			<div class="col-span-full text-center text-gray-600">
				<div class="flex flex-col items-center justify-center space-y-4">
					<div class="flex items-center space-x-4">
						<!-- Sad Icon -->
						<ion-icon name="sad-outline" class="text-8xl text-red-500"></ion-icon>
						<!-- Animated Search Icon with Pulse Effect -->
						<ion-icon name="search" class="text-8xl text-red-400 search-icon"></ion-icon>
					</div>
					<h2 class="text-3xl font-semibold text-gray-700">No Matches Found</h2>
					<p class="text-base text-gray-500">It looks like there are no services available for this
						category. Try adjusting your filters or checking back later.</p>
				</div>
			</div>

		@else
			@foreach ($services as $service)
				<div class="p-2">
					<div class="overflow-hidden rounded-lg bg-gray-100">
						<div class="h-[160px] w-full bg-red-100 md:h-[180px]">
							<img class="h-full w-full object-cover"
							     src="{{ asset('storage/services/' . $service->image) }}"
							     alt="{{ $service->title }}">
						</div>
						<div class="px-3 py-4">
							<div class="flex items-center justify-between">
								<h3 class="text-sm font-medium text-gray-700">{{ $service->title }}</h3>
								<span class="inline-block rounded-md bg-green-200 p-1 text-sm text-gray-500">Ksh.
                                        {{ number_format($service->price) }}</span>
							</div>
							<div class="mt-4 flex items-center justify-between">
								<a href="{{ route('services.show', $service->id) }}"
								   class="duration-600 inline-block flex-1 rounded-lg bg-blue-500 px-4 py-2 text-center text-white transition-all hover:bg-blue-800 hover:outline-none hover:ring-1 hover:ring-black">
									View Service
								</a>
								<a href="{{ route('freelancer.services', $service->freelancer->id) }}" class="">
									<img width="35px" height="35px"
									     class="duration-600 ml-2 h-9 w-9 rounded-full transition-all hover:outline-none hover:ring-2 hover:ring-gray-800"
									     src="{{ asset('storage/avatars/' . $service->freelancer->photo) }}"
									     alt="{{ $service->freelancer->name }}"/>
								</a>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>
	<div class="mt-4">
		{{ $services->appends(request()->input())->links() }}
	</div>
</section>

<x-footer></x-footer>
<x-scripts></x-scripts>
</body>

</html>
