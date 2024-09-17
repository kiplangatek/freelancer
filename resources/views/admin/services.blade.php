<!doctype html>
<html lang="en" data-bs-theme-mode="system" class="font-sans">

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
		}
	</style>
</head>

<body class="inter-body h-full bg-gray-200" x-data="{ activeTab: 'services' }">
<section class="mx-auto mb-10">
	<div class="w-full bg-gray-200">
		<div id=" dheader"
		     class="sticky top-0 z-50 mx-auto w-full bg-gray-400 bg-opacity-70 px-2 py-5 backdrop-blur-lg transition-all duration-300">
			<nav class="flex w-full items-center justify-between">
				@if (Auth::user()->usertype === 'admin')
					<a href="/admin/reports" class="flex h-14 w-fit items-center px-1 text-lg font-bold md:h-16">
						<ion-icon class="mx-1 text-3xl" name="chevron-back"></ion-icon>
						<span class="hidden md:block">Back</span>
					</a>
				@else
					<a href="/" class="flex h-14 w-fit items-center px-1 text-lg font-bold md:h-16">
						<ion-icon class="mx-1 text-3xl" name="chevron-back"></ion-icon>
						<span class="hidden md:block">Back</span>
					</a>
				@endif

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
		<div class="mt-4 px-4 md:px-12">
			<div class="h-24 w-24 overflow-hidden rounded-full bg-gray-300">
				<img class="h-full w-full" src="{{ asset('storage/avatars/' . Auth::user()->photo) }}" alt="">
			</div>
			<div class="flex items-center justify-between">
				<div>
					<div class="flex items-baseline">
						<h2 class="mt-4 text-lg font-bold">{{ Auth::user()->name }}</h2>
						@if (Auth::user()->verified)
							<span
								class="p1 h-4 w-4 items-center rounded-full bg-blue-500 text-sm text-white">✔</span>
							@if (Auth::user()->usertype !== 'admin')
								@php
									$bgColor = 'bg-gray-300'; // Default background color
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

						@endif
					</div>
					<p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
				</div>
				<button class="mt-4 rounded-lg bg-blue-300 px-4 py-2 text-white">Edit Profile</button>
			</div>
		</div>
	</div>
	<div class="px-8 py-10 md:px-10">
		<div class="container relative">
			<!-- Tab navigation -->
			<div class="mb-4 overflow-x-auto">
				<div class="flex whitespace-nowrap border-b-2 border-gray-300">
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
						        @click="activeTab = 'active'" class="px-4 py-2 text-sm font-medium text-gray-700">
							Active Applications
						</button>
					@endif
					<button :class="activeTab === 'applications' ? 'tab-button active' : 'tab-button'"
					        @click="activeTab = 'applications'"
					        class="px-4 py-2 text-sm font-medium text-gray-700">
						My Applications
					</button>
					<button :class="activeTab === 'dashboard' ? 'tab-button active' : 'tab-button'"
					        @click="activeTab = 'dashboard'" class="px-4 py-2 text-sm font-medium text-gray-700">
						Analysis
					</button>
				</div>
			</div>
		</div>

		@if (session('success'))
			<x-alert type="success" :message="session('success')"/>
		@endif

		@if (session('error'))
			<x-alert type="error" :message="session('error')"/>
		@endif

		<!-- Tab content -->
		@if (Auth::user()->usertype === 'freelancer')
			<div id="services-content" :class="activeTab === 'services' ? 'tab-content active' : 'tab-content'"
			     class="mt-4">
				<h1 class="mb-4 text-2xl font-bold">My Services</h1>
				<!-- Services content here -->
				<div class="mx-auto grid grid-cols-1 gap-0.5 md:grid-cols-2 md:gap-6 lg:grid-cols-3 xl:grid-cols-4">
					@foreach ($services as $service)
						<div id="dialog-bg-{{ $service->id }}"
						     class="fixed inset-0 hidden bg-gray-500 bg-opacity-90 transition-opacity"
						     aria-hidden="true">
						</div>

						<div id="dialog-{{ $service->id }}"
						     class="fixed inset-0 z-10 hidden w-screen overflow-y-auto opacity-0 transition-opacity duration-500">
							<div
								class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
								<div
									class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
									<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
										<div class="sm:flex sm:items-start">
											<div
												class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-400 sm:mx-0 sm:h-10 sm:w-10">
												<svg width="25px" xmlns="http://www.w3.org/2000/svg"
												     class="ionicon"
												     viewBox="0 0 512 512">
													<path
														d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320"
														fill="none" stroke="currentColor"
														stroke-linecap="round"
														stroke-linejoin="round" stroke-width="32"/>
													<path stroke="currentColor" stroke-linecap="round"
													      stroke-miterlimit="10"
													      stroke-width="30" d="M80 112h352"/>
													<path
														d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224"
														fill="none" stroke="currentColor"
														stroke-linecap="round"
														stroke-linejoin="round" stroke-width="30"/>
												</svg>
											</div>
											<div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
												<h3 class="text-base font-semibold leading-6 text-gray-900"
												    id="modal-title">
													{{ $service->title }}</h3>
												<h4 class="text-md font-bold leading-6 text-gray-900">{{ $service->price }}
												</h4>
												<div class="mt-2">
													<h4 class="text-lg font-semibold">Are you sure you want
														to delete
														this?
													</h4>
													<p class="text-sm text-gray-500">Check first if there
														are any active
														applications.</p>
												</div>
											</div>
										</div>
									</div>
									<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
										<form action="/services/{{ $service->id }}" method="post">
											@csrf
											@method('DELETE')
											<button type="submit"
											        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
												Delete
											</button>
										</form>
										<button type="button"
										        onclick="hideDialog('dialog-{{ $service->id }}')"
										        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
											Cancel
										</button>
									</div>
								</div>
							</div>
						</div>
						<div class="p-2">
							<div class="overflow-hidden rounded-lg bg-gray-100 shadow-lg">
								<div class="h-32 w-full bg-red-100 md:h-[180px] lg:max-h-60">
									<img class="h-full w-full object-cover"
									     src="{{ asset('storage/services/' . $service->image) }}"
									     alt="{{ $service->title }}">
								</div>
								<div class="px-2 py-4">
									<div class="flex justify-between">
										<h3 class="text-[13px] font-semibold text-gray-700 md:text-sm md:font-medium">
											{{ $service->title }}</h3>
										<h3
											class="rounded-md bg-green-300 p-1 text-[13px] font-medium text-gray-800 md:text-sm">
											{{ $service->price }}</h3>
									</div>
									<div class="mt-4 flex items-center justify-between">
										<a href="{{ route('services.show', $service->id) }}"
										   class="inline-block flex-1 rounded-md bg-black px-4 py-2 text-center text-white">View
											Service</a>
										<button type="button"
										        onclick="showDialog('dialog-{{ $service->id }}')"
										        class="ml-2.5 inline-flex w-fit justify-center rounded-md bg-red-600 px-4 py-2 font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
											Delete
										</button>
									</div>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div id="create-service-content"
			     :class="activeTab === 'create-service' ? 'tab-content active' : 'tab-content'" class="mt-4">
				<!-- Create service content here -->
				<div class="mx-auto w-[95%] px-3 py-4 shadow-md md:w-1/2">
					<h2 class="text-center text-2xl font-bold leading-tight text-black">
						Create A Service
					</h2>
					<form id="service-form" class="mt-6 w-full" method="POST"
					      action="{{ route('services.store') }}" enctype="multipart/form-data">
						@csrf
						<div class="space-y-4 md:grid md:grid-cols-2 md:gap-4 md:space-y-0">
							<div>
								<x-label>Service Title</x-label>
								<x-input type="text" name="title" placeholder="Title" required/>
								<x-form-error name="title"/>
							</div>
							<div>
								<x-label>Service Price</x-label>
								<x-input type="text" name="price" placeholder="Price in Ksh Numbers only"
								         required/>
								<x-form-error name="price"/>
							</div>
							<div class="col-span-2">
								<x-label>Description</x-label>
								<x-textarea/>
								<x-form-error name="details"/>
								<input type="hidden" name="details_hidden" id="details_hidden">
							</div>
							<div class="col-span-2">
								<x-label>Image</x-label>
								<x-input type="file" name="image"/>
								<x-form-error name="image"/>
							</div>
							<div class="col-span-2 flex justify-between gap-1">
								<x-form-button class="w-[60%] px-2 py-1.5">
									CREATE SERVICE
								</x-form-button>
								<x-form-button type="button"
								               class="w-fit flex-1 bg-red-200 px-2 py-1.5 hover:bg-red-500"
								               onClick="document.getElementById('service-form').reset();">
									CLEAR
								</x-form-button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div id="active-content" :class="activeTab === 'active' ? 'tab-content active' : 'tab-content'"
			     class="mt-4">
				<!-- Active applications content here -->
				<div class="grid grid-cols-1 gap-3 px-2 md:grid-cols-2 lg:grid-cols-3">
					@forelse ($activeApplications as $activeapplication)
						<div class="mb-4 rounded-md bg-gray-300 shadow-md">
							<img height="144px"
							     class="mx-auto mb-3 h-36 w-full rounded-tl-md rounded-tr-md object-cover"
							     src="{{ asset('storage/services/' . $activeapplication->service->image) }}"
							     alt="{{ $activeapplication->service->title }}">
							<h2 class="text-md px-4 font-semibold">{{ $activeapplication->service->title }}</h2>
							<div class="flex justify-between px-4">
								<p class="flex items-center p-1 py-1 text-gray-600">
									<ion-icon name="person-circle"></ion-icon>
									{{ $activeapplication->applicant->name }}
								</p>
								<h3 class="w-fit rounded-md bg-green-300 p-1 text-sm font-medium text-gray-800">
									{{ $activeapplication->service->price }}
								</h3>
							</div>
							<p class="px-4 pb-2 text-gray-600">Status:
								{{ $activeapplication->created_at->diffForHumans() }}</p>

							<!-- Add the cancel button with a form -->
							<div class="px-4 pb-4">
								{{-- <form action="{{ route('services.my.cancel', $activeapplication->id) }}"
										method="POST">
										@csrf
										@method('DELETE')
										<x-form-button>
										   Cancel Request
										</x-form-button>
									  </form> --}}
							</div>
						</div>
					@empty
						<p class="text-gray-600">No applications found.</p>
					@endforelse
				</div>
			</div>
		@endif

		<div id="applications-content" :class="activeTab === 'applications' ? 'tab-content active' : 'tab-content'"
		     class="mt-4">
			<h1 class="mb-4 px-1 text-2xl font-bold">My Applications</h1>
			<!-- Applications content here -->
			@if (session('status'))
				<x-alert type="success" :message="session('status')"/>
			@endif

			@if ($applications->isEmpty())
				<p>You have no applications.</p>
			@else
				<div class="mx-auto grid grid-cols-1 gap-3 px-2 md:grid-cols-2 lg:grid-cols-3">
					@foreach ($applications as $application)
						<div class="rounded-md bg-gray-300 shadow-md">
							<img height="144px"
							     class="mx-auto mb-3 h-36 w-full rounded-tl-md rounded-tr-md object-cover"
							     src="{{ asset('storage/services/' . $application->service->image) }}"
							     alt="{{ $application->service->title }}">
							<h2 class="text-md px-4 font-semibold">{{ $application->service->title }}</h2>
							<div class="flex justify-between px-4">
								<p class="flex items-center p-1 py-1 text-gray-600">
									<ion-icon name="person-circle"></ion-icon>
									{{ $application->freelancer->name }}
								</p>
								<h3 class="w-fit rounded-md bg-green-300 p-1 text-sm font-medium text-gray-800">
									{{ $application->service->price }}
								</h3>
							</div>
							<p class="px-4 pb-2 text-gray-600">
								Status: {{ $application->created_at->diffForHumans() }}
							</p>

							<!-- Add the cancel button with a form -->
							<div class="mx-auto px-4 pb-4">
								<form action="{{ route('services.my.cancel', $application->id) }}"
								      method="POST">
									@csrf
									@method('DELETE')
									<x-form-button>
										Cancel Request
									</x-form-button>
								</form>
							</div>
						</div>
					@endforeach
				</div>
			@endif
		</div>

		<div id="dashboard-content" :class="activeTab === 'dashboard' ? 'tab-content active' : 'tab-content'"
		     class="mt-4">
			<!-- Analysis content here -->
		</div>
	</div>
</section>
</body>

</html>
