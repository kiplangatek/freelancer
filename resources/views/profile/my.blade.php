<!doctype html>
<html lang="en" data-bs-theme-mode="system" class="h-full">

<head>
	<!-- Other head content here -->
	<meta charset="UTF-8">
	<meta name="viewport"
		 content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	<title>Dashboard|Profile</title>
	<script src="https://unpkg.com/alpinejs" defer></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<script src="https://cdn.tiny.cloud/1/ot6e0um59efmqke5zvj35ugpqo1fhsrai2wmwnwwftxua7wz/tinymce/6/tinymce.min.js"
		   referrerpolicy="origin"></script>
	@vite(['resources/css/app.css'])
	<style>
		.tab-content {
			display: none;
		}

		.tab-content.active {
			display: block;
		}

		.tab-button {
			color: gray;
		}

		.tab-button.active {
			background-color: #3b82f6;
			/* Tailwind's blue-500 */
			color: white;
			border-radius: 24px;
		}

		#freelancerAnalysisChart {
			max-width: 600px;
			margin: 0 auto;
		}


		.hide-scrollbar {
			overflow-x: auto; /* Enable horizontal scrolling */
			-ms-overflow-style: none; /* IE and Edge */
			scrollbar-width: none; /* Firefox */
		}

		.hide-scrollbar::-webkit-scrollbar {
			display: none; /* Chrome, Safari */
		}
	</style>
</head>

<body class="h-full bg-gray-200 font-inter" x-data="{ activeTab: localStorage.getItem('activeTab') || 'services' }"
	 x-init="$watch('activeTab', value => localStorage.setItem('activeTab', value))">
<section class="mx-auto mb-10">
	<div class="w-full bg-gray-200">
		<div id=" dheader"
			class="sticky top-0 z-50 mx-auto w-full bg-gray-400 bg-opacity-70 px-2 py-5 backdrop-blur-lg transition-all duration-300">
			<nav class="flex w-full items-center justify-between">
				<a href="/" class="flex h-14 w-fit items-center px-1 text-lg font-bold md:h-16">
					<ion-icon class="mx-1 text-3xl" name="chevron-back"></ion-icon>
					<span class="hidden md:block">Back</span>
				</a>

				<form method="post" action="/logout" class="block">
					@csrf
					<button type="submit"
						   class="flex w-full items-center rounded-lg bg-red-500 px-2 py-2 text-left text-white">
						<ion-icon class="mx-2 text-lg font-bold" name="log-out"></ion-icon>
						LOGOUT
					</button>
				</form>
			</nav>
		</div>
		<div class=" px-4 md:px-12 bg-gray-300 py-4">
			<div class="flex justify-between">
				<div class="h-24 w-24 overflow-hidden rounded-full bg-gray-300">
					<img class="h-full w-full object-cover"
						src="{{ asset('storage/avatars/' . Auth::user()->photo) }}" alt="">
				</div>
				<div class="relative">
					<div class="relative">
						@if ($unreadCount > 0)
							<span
								class="absolute -top-[5px] -right-[5px] bg-red-500 text-white text-xs h-5 w-5 font-bold rounded-full z-10 flex items-center justify-center">
							   {{ $unreadCount > 9 ? '9+' : $unreadCount }}
						    </span>
						@endif

						<a href="/messages" class="text-2xl text-blue-600">
							<ion-icon name="chatbubble-ellipses-outline" size="large"></ion-icon>
						</a>
					</div>
				</div>
			</div>
			<div class="flex items-center justify-between">
				<div>
					<div class="flex items-baseline">
						<h2 class="mt-4 text-lg font-bold">{{ Auth::user()->name }}</h2>
						@if (Auth::user()->verified)
							<span class="p1 h-4 w-4 items-center text-lg font-bold text-blue-500"><ion-icon
									name="checkmark-done-circle"></ion-icon> </span>
						@endif
						@if (Auth::user()->usertype !== 'admin')
							@php
								$bgColor = 'bg-gray-300';
								if ($averageRating >= 4) {
								    $bgColor = 'bg-green-300';
								} elseif ($averageRating >= 3) {
								    $bgColor = 'bg-yellow-300';
								} elseif ($averageRating >= 2) {
								    $bgColor = 'bg-gray-300';
								} elseif ($averageRating >= 1) {
								    $bgColor = 'bg-red-200';
								}
							@endphp
							<span
								class="align-self-baseline {{ $bgColor }} ml-2 flex items-center rounded-md p-1 text-sm text-gray-800">
                                 {{ $averageRating }} <ion-icon name="star"></ion-icon>
                              </span>
						@endif
					</div>
					<p class="text-sm text-gray-600 flex items-center">
						<ion-icon name="at"></ion-icon>{{ Auth::user()->username }}</p>
					<p class="text-sm text-gray-600 flex items-center italic">Joined:
						&nbsp;{{ Auth::user()->created_at->format('jS M, Y') }}

				</div>
				<a href="{{ route('profile') }}"
				   class="mt-4 inline-block rounded-lg bg-blue-300 px-4 py-2 text-center text-white">
					Edit Profile
				</a>

			</div>
		</div>
	</div>
	<div class="px-6 py-6 md:px-8">
		<div class="container relative">
			<div class="mb-4 overflow-x-auto">
				@if(Auth::user()->usertype!=='admin')

					<div class="flex whitespace-nowrap hide-scrollbar">
						@if (Auth::user()->usertype === 'freelancer')
							<button :class="activeTab === 'services' ? 'tab-button active' : 'tab-button'"
								   @click="activeTab = 'services'"
								   class="px-4 py-2 text-sm font-medium text-gray-700">
								My Services
							</button>
							<button :class="activeTab === 'create-service' ? 'tab-button active' : 'tab-button'"
								   @click="activeTab = 'create-service'"
								   class="px-4 py-2 text-sm font-medium text-gray-700">
								Create Service
							</button>
							<button :class="activeTab === 'active' ? 'tab-button active' : 'tab-button'"
								   @click="activeTab = 'active'"
								   class="px-4 py-2 text-sm font-medium text-gray-700">
								Active Applications
							</button>
						@endif
						<button :class="activeTab === 'applications' ? 'tab-button active' : 'tab-button'"
							   @click="activeTab = 'applications'"
							   class="px-4 py-2 text-sm font-medium text-gray-700">
							My Applications
						</button>
						<button :class="activeTab === 'dashboard' ? 'tab-button active' : 'tab-button'"
							   @click="activeTab = 'dashboard'"
							   class="px-4 py-2 text-sm font-medium text-gray-700">
							Analysis
						</button>
					</div>

			</div>
			@endif
		</div>
		@if (session('success'))
			<x-alert type="success" :message="session('success')" />
		@endif

		@if (session('error'))
			<x-alert type="error" :message="session('error')" />
		@endif

		<!-- Tab content -->
		@if(Auth::user()->usertype!=='admin')
			@if (Auth::user()->usertype === 'freelancer')
				<div id="services-content" :class="activeTab === 'services' ? 'tab-content active' : 'tab-content'"
					class="mt-4">
					<h1 class="mb-4 text-2xl font-bold">My Services</h1>
					<!-- Services content here -->
					<div class="mx-auto grid grid-cols-1 gap-0.5 md:grid-cols-2 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
						@foreach ($services as $service)
							<!-- Background overlay for the modal -->
							<div id="dialog-bg-{{ $service->id }}"
								class="fixed inset-0 hidden bg-gray-500 bg-opacity-90 transition-opacity"
								aria-hidden="true">
							</div>

							<!-- Delete confirmation modal -->
							<div id="dialog-{{ $service->id }}"
								class="fixed inset-0 z-10 hidden w-screen overflow-y-auto opacity-0 transition-opacity duration-500">
								<div
									class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
									<div
										class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
										<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
											<div class="sm:flex sm:items-start">
												<div
													class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
													<ion-icon name="warning"
															class="text-lg text-red-500"></ion-icon>
												</div>
												<div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
													<h3 class="text-lg font-medium leading-6 text-gray-900"
													    id="modal-title">
														Delete {{ $service->title }}</h3>
													<div class="mt-2">
														<p class="text-sm text-gray-500">Are you sure you
															want
															to delete
															this
															service? This action cannot be undone.</p>
													</div>
												</div>
											</div>
										</div>
										<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
											<button type="button"
												   class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-500 px-4 py-2 text-base font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
												   onclick="event.preventDefault(); document.getElementById('delete-service-form-{{ $service->id }}').submit();">
												Delete
											</button>
											<form id="delete-service-form-{{ $service->id }}" method="POST"
												 action="{{ route('services.destroy', $service) }}"
												 class="hidden">
												@csrf
												@method('DELETE')
											</form>
											<button type="button"
												   class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3 sm:mt-0 sm:w-auto sm:text-sm"
												   onclick="toggleModal({{ $service->id }})">Cancel
											</button>
										</div>
									</div>
								</div>
							</div>

							<!-- Service card -->
							<div class="relative mb-6 block w-full max-w-md overflow-hidden rounded-lg border bg-white shadow-md sm:max-w-xs">
								<!-- Service Image -->
								<img src="{{ asset('storage/services/' . $service->image) }}"
									alt="{{ $service->title }} image"
									class="mb-4 h-36 w-full rounded-t-lg object-cover">

								<!-- Overlay for Featured Status -->
								@if ($service->featured)
									<div class="absolute left-2 top-2">
            							<span
										class="inline-block rounded-lg bg-blue-500 px-2 py-1 text-xs font-medium uppercase text-white">Featured</span>
									</div>
								@endif

								<!-- Price Overlay -->
								<div class="absolute right-2 top-2 bg-green-100 px-2 py-1 rounded-lg shadow-md">
									<span
										class="text-sm font-bold text-gray-800">Ksh. {{ number_format($service->price) }}</span>
								</div>

								<!-- Service Details -->
								<div class="mb-2 flex items-center justify-between px-4 py-2">
									<span
										class="inline-block text-sm font-bold text-gray-800">{{ $service->title }}</span>
									<a href="/services/{{ $service->id }}/edit"
									   class="text-gray-500 hover:text-gray-700">
										<ion-icon name="create" size="small" class="align-middle"></ion-icon>
									</a>
								</div>

								<!-- Service Category and Delete Button -->
								<div class="flex items-center justify-between px-2 pb-4">
								   <span
									   class="inline-block rounded-lg bg-blue-500 px-2 py-1 text-xs font-medium uppercase text-white">
									  {{ $service->category->name }}
								   </span>
									<button class="text-red-500 hover:text-red-600 focus:outline-none"
										   onclick="toggleModal({{ $service->id }})">
										<ion-icon name="trash"></ion-icon>
									</button>
								</div>
							</div>

						@endforeach

					</div>
				</div>

				<div id="create-service-content"
					:class="activeTab === 'create-service' ? 'tab-content active' : 'tab-content'" class="mt-4">
					<h1 class="mb-4 text-2xl font-bold">Create Service</h1>
					<!-- Create Service content here -->
					<form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
						@csrf
						<div class="mb-4">
							<x-label class="block text-sm font-medium text-gray-700" for="title">Title</x-label>
							<x-input name="title"
								    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
							<x-form-error name="title"></x-form-error>
						</div>
						<div class="mb-4">
							<x-label class="block text-sm font-medium text-gray-700" for="price">Price</x-label>
							<x-input type="number" name="price" id="price" placeholder="Price in Ksh."
								    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" />
							<x-form-error name="price"></x-form-error>
						</div>

						<div class="mb-4">
							<x-label class="block text-sm font-medium text-gray-700" for="category">Category
							</x-label>
							<select name="category_id" id="category_id"
								   class="mt-1 block h-9 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
								@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
								@endforeach
							</select>

							<x-form-error name="category_id"></x-form-error>
						</div>

						<div class="mb-4">
							<x-label class="block text-sm font-medium text-gray-700" for="details">Description
							</x-label>
							<x-textarea name="details"
									  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm mb-3"></x-textarea>
							<x-form-error name="details"></x-form-error>
						</div>

						<div class="flex flex-col items-center justify-center p-2 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50"
							id="drop-area">
							<div class="mb-2">
								<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 512 512">
									<rect x="48" y="80" width="416" height="352" rx="48" ry="48" fill="none"
										 stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
									<circle cx="336" cy="176" r="32" fill="none" stroke="currentColor"
										   stroke-miterlimit="10" stroke-width="32" />
									<path
										d="M304 335.79l-90.66-90.49a32 32 0 00-43.87-1.3L48 352M224 432l123.34-123.34a32 32 0 0143.11-2L464 368"
										fill="none" stroke="currentColor" stroke-linecap="round"
										stroke-linejoin="round" stroke-width="32" />
								</svg>
							</div>
							<p class="mb-1 text-sm text-gray-600">
								<span class="font-semibold text-blue-600 cursor-pointer" id="upload-trigger">Upload a file</span>
								or drag and drop
							</p>
							<p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>

							<input id="file-upload" type="file" name="image" class="hidden" />
							<p id="file-name" class="text-sm text-gray-600"></p>
						</div>
						<x-form-error name="image" />
						<div class="flex justify-end mt-2">
							<button type="submit" class="rounded-lg bg-blue-500 px-4 py-2 text-white">Create
								Service
							</button>
						</div>
					</form>

				</div>
			@endif
			<div id="applications-content"
				:class="activeTab === 'applications' ? 'tab-content active' : 'tab-content'" class="mt-4">
				<h1 class="mb-4 text-3xl font-bold">My Applications</h1>

				<!-- Applications Grid -->
				<div class="mx-auto grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
					@foreach ($applications as $application)
						@php
							$service = $application->service;
						@endphp

							<!-- Application Card -->
						<div class="relative block w-full mx-auto overflow-hidden rounded-lg border border-gray-300 bg-white shadow-lg">
							<div class="">
								<!-- Status Badge (Top Right Corner) -->
								@php
									$statusClass = '';
									$statusText = '';

									if ($application->status && $application->client_status) {
										$statusText = 'Completed';
										$statusClass = 'text-gray-600 bg-green-200'; // Both true
									} elseif ($application->status || $application->client_status) {
										$statusText = 'In Progress'; // Change to whatever fits your logic
										$statusClass = 'text-gray-600 bg-gradient-to-r from-yellow-200 to-green-200'; // One true
									} else {
										$statusText = 'Pending';
										$statusClass = 'text-gray-600 bg-amber-100'; // None true
									}
								@endphp

								<span
									class="absolute top-2 right-2 text-sm font-semibold px-2 py-1 rounded-md {{ $statusClass }}">
									{{ $statusText }}
								</span>

								<!-- Display Service Image -->
								@if($service->image)
									<img src="{{ asset('storage/services/' . $service->image) }}"
										alt="{{ $service->title }}"
										class="w-full h-36 object-cover rounded-lg rounded-b-none mb-1">
								@else
									<div class="w-full h-36 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
										No Image Available
									</div>
								@endif

								<!-- Service Title and Price Info -->
								<div class="px-2 py-2">
									<span
										class="text-lg font-semibold text-gray-800">{{ $service->title }}</span>
									<div class="mb-1 text-sm text-gray-500">
										<span>Price: Ksh. {{ number_format($service->price) }}</span>
									</div>
								</div>

								<!-- View Details Button -->
								<a href="{{ route('applications.view', $application->id) }}"
								   class="block mt-2 w-[95%] mb-2 mx-auto text-center bg-blue-600 text-white py-2 rounded-3xl font-medium hover:bg-blue-700 transition-colors">
									View Details
								</a>
							</div>
						</div>
					@endforeach
				</div>
			</div>

			<div id="dashboard-content" :class="activeTab === 'dashboard' ? 'tab-content active' : 'tab-content'"
				class="mt-4">
				<h1 class="mb-4 text-2xl font-bold">Analysis</h1>
				<!-- Analysis content here -->
				<div class=" mx-auto ">

					@if(Auth::user()->usertype ==='client')
						<div class="grid grid-cols-1 gap-6">
							<div class="grid grid-cols-2 md:grid-cols-4 gap-2">
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="document-text-outline"
												class="text-blue-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">My Requests</h3>
										<p id="requests" class="text-2xl font-bold text-blue-600">18</p>
									</div>
								</div>
								<!-- My Spend Card -->
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="cash-outline"
												class="text-purple-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">My Spend</h3>
										<p id="spending" class="text-2xl font-bold text-purple-600">Ksh
											45,000</p>
									</div>
								</div>
								<!-- Average Monthly Spend Card -->
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto  text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="analytics-outline"
												class="text-green-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Avg. Monthly Spend</h3>
										<p id="averageSpend" cla`ss="text-2xl font-bold text-green-600">
											Ksh
											15,000</p>
									</div>
								</div>
								<div class="bg-white shadow-lg rounded-lg p-2  w-full  text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="checkmark-done-circle-outline"
												n class="text-green-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Completed</h3>
										<p id="completed" class="text-2xl font-bold text-green-600">
											19</p>
									</div>
								</div>
							</div>
						</div>
					@endif
					@if (Auth::user()->usertype === 'freelancer')

						<div class="grid grid-cols-1 gap-6">
							<div class="grid grid-cols-2 md:grid-cols-3 gap-2">
								<!-- Total Requests Card -->
								<div id="client-analysis"
									class="bg-blue-50 shadow-lg rounded-lg p-4 w-full text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="git-compare-outline"
												class="text-purple-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Client Requests</h3>
										<p id="requestCount" class="text-3xl font-bold text-purple-600">2</p>
										<!-- Client label with bg-blue-300 -->
									</div>
								</div>
								<!-- Completed Requests Card -->
								<div id="client-analysis"
									class="bg-blue-50 shadow-lg rounded-lg p-4  w-full text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="checkmark-circle-outline"
												class="text-green-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Client Completed</h3>
										<p id="completedRequests" class="text-3xl font-bold text-green-600">
											4</p>
									</div>
								</div>

								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="document-text-outline"
												class="text-blue-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">My Requests</h3>
										<p id="applications" class="text-3xl font-bold text-blue-600"></p>
									</div>
								</div>
								<div class="bg-white shadow-lg rounded-lg p-2  w-full text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="checkmark-done-circle-outline"
												class="text-blue-600 text-2xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Completed</h3>
										<p id="myCompletedRequests" class="text-3xl font-bold text-green-600">
											4</p>
									</div>
								</div>
								<!-- My Spend Card -->
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="cash-outline"
												class="text-purple-600 text-3xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">My Spend</h3>
										<p id="mySpend" class="text-xl font-bold text-purple-600">Ksh
											45,000</p>
									</div>
								</div>
								<!-- Average Monthly Spend Card -->
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="analytics-outline"
												class="text-green-600 text-3xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">Avg. Monthly Spend</h3>
										<p id="avgSpending" class="text-xl font-bold text-green-600">
											Ksh
											15,000</p>
									</div>
								</div>

								<!-- Total Services Card -->
								<div class="bg-white shadow-lg rounded-lg p-2  w-full h-auto text-center">
									<div class="flex flex-col items-center">
										<ion-icon name="briefcase-outline"
												class="text-blue-600 text-3xl mb-2"></ion-icon>
										<h3 class="text-base font-bold text-gray-700">My Services</h3>
										<p id="serviceCount" class="text-2xl font-bold text-blue-600">5</p>
									</div>
								</div>
								<!-- Current Month Earnings Card -->
								<div
									x-data="{ percentageChange: 0, currentMonthEarnings: 1000 }"
									x-init="fetch('/my/analysis')
								   .then(response => response.json())
								   .then(data => {
									  percentageChange = data.percentageChange;
									  currentMonthEarnings = data.currentMonthEarnings;
								   })"
									class="bg-white shadow-lg rounded-lg p-4 w-full text-center relative">

									<div class="flex flex-col items-center">
										<!-- Calendar Icon -->
										<ion-icon name="calendar-outline"
												class="text-indigo-600 text-3xl mb-2"></ion-icon>

										<!-- Month Label -->
										<h3 class="text-base font-bold text-gray-700 mb-1">This Month</h3>

										<!-- Earnings and Percentage Change -->
										<div class="relative flex items-center justify-center">
											<!-- Current Month Earnings -->
											<span id="currentMonthEarnings"
												 class="text-lg font-semibold text-indigo-600">
											  Ksh. <span x-text="Number(currentMonthEarnings).toLocaleString('en-KE')"></span>
											</span>


										</div>

										<!-- Percentage Change (Absolute Position) -->
										<span id="change"
											 class="text-sm font-semibold px-2 py-1 rounded-lg absolute top-0 right-0 m-0.5"
											 :class="{
												 'bg-green-100 text-green-700': percentageChange > 0,
												 'bg-red-100 text-red-700': percentageChange < 0,
												 'bg-gray-100 text-gray-700': percentageChange == 0
											  }">
											  <span x-text="percentageChange + '%'"></span>
										   </span>

										<!-- Deduction Notice -->
										<p class="text-xs text-gray-500 mt-2">*After 10% fee deduction</p>
									</div>
								</div>


								<!-- Total Earnings Card -->
								<div class="bg-white shadow-lg rounded-lg p-2 w-full text-center col-span-2 md:col-span-1">
									<div class="flex flex-col items-center">
										<ion-icon name="cash-outline"
												class="text-red-600 text-3xl mb-2"></ion-icon>
										<h3 class="text-sm font-bold text-gray-700">All-Time Earnings</h3>
										<p id="totalEarnings" class="text-3xl font-bold text-red-600">Ksh
											99,000.00</p>
										<p class="text-xs text-gray-500">*After 10% fee deduction</p>
										<!-- Deduction notice -->
									</div>
								</div>
							</div>
							<!-- Bar Chart for Earnings Per Month -->
							<div class="bg-white shadow-lg rounded-lg p-4">
								<h3 class="text-xl font-bold text-gray-700 text-center mb-4">Earnings Per
									Month</h3>
								<canvas id="earningsChart" width="350" height="200"></canvas>
							</div>
						</div>
					@endif

				</div>


			</div>

			<div id="active-content" :class="activeTab === 'active' ? 'tab-content active' : 'tab-content'"
				class="mt-4">
				<h1 class="mb-4 text-2xl font-bold">Active Applications</h1>
				<div class="mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
					@foreach($activeApplications as $activeApplication)
						<div class="rounded-lg shadow-md overflow-hidden bg-white mb-4 border border-gray-200 transition-shadow duration-300 hover:shadow-lg w-full mx-auto">
							<div class="h-28 w-full overflow-hidden rounded-t-lg">
								<img class="h-full w-full object-cover"
									src="{{ asset('storage/services/'.$activeApplication->service->image) }}"
									alt="Service Image">
							</div>
							<div class="px-3 py-2">
								<div class="flex items-center mb-1">
									<ion-icon name="person-circle-outline"
											class="text-xl text-blue-600"></ion-icon>
									<p class="flex items-center ml-2 font-semibold text-gray-800 text-sm">{{ $activeApplication->applicant->name }}</p>
								</div>
								<div class="flex items-center mb-1">
									<ion-icon name="mail-outline" class="text-xl text-blue-600"></ion-icon>
									<p class="flex items-center ml-2 text-gray-600 text-sm">{{ $activeApplication->applicant->email }}</p>
								</div>
								<div>
									@if(!$activeApplication->client_status)
										<form
											action="{{ route('applications.update', $activeApplication->id) }}"
											method="POST">
											@csrf
											@method('PATCH')
											<button type="submit"
												   class="{{ $activeApplication->status ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-full shadow-md w-full transition-colors duration-200">
												{{ $activeApplication->status ? 'Mark as Incomplete' : 'Mark as Completed' }}
											</button>
										</form>
									@endif
								</div>
							</div>
						</div>

					@endforeach
				</div>
			</div>

		@endif
		@if(Auth::user()->usertype==='admin')
			<div>
				<a href="/admin" class="p-2 py-3 rounded-md bg-blue-500 text-gray-100">Go to Dashboard</a>
			</div>
		@endif

	</div>
</section>
<x-footer></x-footer>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

	@if(Auth::user()->usertype =='freelancer')
	fetch('/my/analysis')
		.then(response => {
			if (!response.ok) {
				throw new Error('Network response was not ok ' + response.statusText)
			}
			return response.json()
		})
		.then(data => {
			// Update Cards
			document.getElementById('serviceCount').textContent = data.serviceCount
			document.getElementById('requestCount').textContent = data.requestCount
			document.getElementById('completedRequests').innerHTML = `${data.completedRequests} <span class="text-sm">of</span> ${data.requestCount}`
			document.getElementById('myCompletedRequests').innerHTML = `${data.myCompletedRequests} <span class="text-sm">of</span> ${data.applications}`
			document.getElementById('applications').textContent = data.applications
			document.getElementById('change').textContent = `${data.percentageChange}%`
			// Format the total earnings with a Ksh label and proper number format
			const formattedEarnings = new Intl.NumberFormat('en-KE').format(data.totalEarnings)
			const formattedSpend = new Intl.NumberFormat('en-Ke').format(data.mySpend)
			document.getElementById('totalEarnings').textContent = `Ksh. ${formattedEarnings}`

			document.getElementById('mySpend').textContent = `Ksh. ${formattedSpend}`
			// Calculate current month's earnings
			const currentMonth = new Date().getMonth() + 1 // JS months are zero-indexed
			const currentMonthEarnings = data.monthlyEarnings[currentMonth] || 0
			document.getElementById('currentMonthEarnings').textContent = `Ksh. ${new Intl.NumberFormat('en-KE').format(currentMonthEarnings)}`

			const montlyFormatted = new Intl.NumberFormat('en-KE').format(data.averageSpending)

			document.getElementById('avgSpending').textContent = `Ksh. ${montlyFormatted}`

			// Bar Chart for earnings per month
			// Extract labels (YYYY-MM) and values
			const labels = Object.keys(data.monthlyEarnings || {})
			const values = Object.values(data.monthlyEarnings || {})

			const earningsCtx = document.getElementById('earningsChart').getContext('2d')
			new Chart(earningsCtx, {
				type: 'bar',
				data: {
					labels,
					datasets: [
						{
							label: 'Earnings per Month (Bar)',
							data: values,
							backgroundColor: 'rgba(255, 99, 132, 0.2)',
							borderColor: 'rgba(255, 99, 132, 1)',
							borderWidth: 1,
							type: 'bar',
							borderRadius: 10,
							borderSkipped: 'bottom',
						},
						{
							label: 'Earnings per Month (Line)',
							data: values,
							borderColor: 'rgba(54, 162, 235, 1)',
							backgroundColor: 'rgba(156,213,255,0.3)',
							fill: true,
							type: 'line',
							tension: 0.4,
						},
					],
				},
				options: {
					scales: { y: { beginAtZero: true } },
				},
			})



		})
		.catch(error => console.error('Error fetching analysis:', error))
	@endif


	@if(Auth::user()->usertype=='client')
	fetch('/analysis')
		.then(response => {
			if (!response.ok) {
				throw new Error('Network Error' + response.statusText)
			}
			return response.json()
		})
		.then(data => {
			document.getElementById('requests').textContent = data.applications
			const formattedSpending = new Intl.NumberFormat('en-Ke').format(data.spending)
			document.getElementById('spending').textContent = `Ksh. ${formattedSpending}`
			formattedAvgSpending = new Intl.NumberFormat('en-Ke').format(data.averageSpend)
			document.getElementById('averageSpend').textContent = `Ksh. ${formattedAvgSpending}`
			document.getElementById('completed').innerHTML = `${data.completed} <span class="text-sm">of</span> ${data.applications}`
		})
	@endif

</script>

<script>

	function toggleClient() {
		const clientAnalysis = document.querySelectorAll('#client-analysis')

		clientAnalysis.classList.add('hidden')
	}


	function toggleModal(serviceId) {
		const bg = document.getElementById(`dialog-bg-${serviceId}`)
		const dialog = document.getElementById(`dialog-${serviceId}`)
		bg.classList.toggle('hidden')
		dialog.classList.toggle('hidden')
		setTimeout(() => {
			dialog.classList.toggle('opacity-0')
		}, 10)
	}
</script>
<x-scripts></x-scripts>

@if(Auth::user()->usertype =='freelancer')
	<script>
		const fileInput = document.getElementById('file-upload')
		const dropArea = document.getElementById('drop-area')
		const fileNameDisplay = document.getElementById('file-name')
		const uploadTrigger = document.getElementById('upload-trigger')

		uploadTrigger.addEventListener('click', () => {
			fileInput.click()
		})

		fileInput.addEventListener('change', () => {
			displayFileName(fileInput.files[0])
		});

		['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
			dropArea.addEventListener(eventName, preventDefaults, false)
		})

		function preventDefaults(e) {
			e.preventDefault()
			e.stopPropagation()
		}

		dropArea.addEventListener('drop', handleDrop, false)

		function handleDrop(e) {
			let dt = e.dataTransfer
			let files = dt.files
			fileInput.files = files
			displayFileName(files[0])
		}

		function displayFileName(file) {
			if (file) {
				fileNameDisplay.textContent = `Selected file: ${file.name}`
			} else {
				fileNameDisplay.textContent = ''
			}
		}


	</script>
@endif
</body>

</html>
