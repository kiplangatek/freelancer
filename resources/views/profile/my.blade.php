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
		<div class="mt-4 px-4 md:px-12">
			<div class="h-24 w-24 overflow-hidden rounded-full bg-gray-300">
				<img class="h-full w-full" src="{{ asset('storage/avatars/' . Auth::user()->photo) }}" alt="">
			</div>
			<div class="flex items-center justify-between">
				<div>
					<div class="flex items-baseline">
						<h2 class="mt-4 text-lg font-bold">{{ Auth::user()->name }}</h2>
						@if (Auth::user()->verified)
							<span class="p1 h-4 w-4 items-center text-lg font-bold text-blue-500"><ion-icon
									name="checkmark-done"></ion-icon> </span>
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

						@endif
					</div>
					<p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
				</div>
				<a href="{{ route('profile') }}"
				   class="mt-4 inline-block rounded-lg bg-blue-300 px-4 py-2 text-center text-white">
					Edit Profile
				</a>

			</div>
		</div>
	</div>
	<div class="px-6 py-10 md:px-8">
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
							$freelancer = $service->freelancer;
						@endphp

							<!-- Application Card -->
						<div class="block w-full max-w-md overflow-hidden rounded-lg border border-gray-300 bg-white shadow-lg">
							<div class="">
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

								<!-- Service Title and Status -->
								<div class=" flex items-center justify-between px-2 py-1">
									<span
										class="text-lg font-semibold text-gray-800">{{ $service->title }}</span>
									<span
										class="text-sm font-semibold px-2 py-1 rounded-md  {{ $application->status ? 'text-ray-600 bg-green-200' : 'text-gray-600 bg-amber-100' }}">
									{{ $application->status ? 'Completed' : 'Pending' }}
								</span>
								</div>

								<!-- Freelancer and Price Info -->
								<div class="mb-1 text-sm text-gray-500 px-2 py-1">
								<span
									class="block font-bold text-gray-700">{{ $freelancer->name ?? 'No Freelancer' }}</span>
									<span>Price: Ksh. {{ number_format($service->price) }}</span>
								</div>

								<!-- View Details Button -->

								<a href="{{ route('applications.view', $application->id) }}"
								   class="block mt-2 w-[95%] mb-2 mx-auto text-center bg-blue-600 text-white py-2 rounded-2xl font-medium hover:bg-blue-700 transition-colors">
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
			</div>

			<div id="active-content" :class="activeTab === 'active' ? 'tab-content active' : 'tab-content'"
				class="mt-4">
				<h1 class="mb-4 text-2xl font-bold">Active Applications</h1>
				<div class="mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
					@foreach($activeApplications as $activeApplication)
						<div class="rounded-md shadow-sm overflow-hidden bg-white mb-4">
							<div class="h-36 w-full overflow-hidden">
								<img class="h-full w-full object-cover"
									src="{{ asset('storage/services/'.$activeApplication->service->image) }}"
									alt="Service Image">
							</div>
							<div class="px-3 py-2">
								<div class="flex items-center mb-2">
									<ion-icon name="person-circle-outline" class="text-2xl"></ion-icon>
									<p class="flex items-center ml-2">{{ $activeApplication->applicant->name }}</p>
								</div>
								<div class="flex items-center mb-2">
									<ion-icon name="mail-outline" class="text-2xl"></ion-icon>
									<p class="flex items-center ml-2">{{ $activeApplication->applicant->email }}</p>
								</div>

								<div>
									<form action="{{ route('applications.update', $activeApplication->id) }}"
										 method="POST">
										@csrf
										@method('PATCH')

										<x-form-button type="submit"
													class="{{ $activeApplication->status ? 'bg-blue-500 hover:bg-blue-600' : 'bg-green-500 hover:bg-green-600' }} text-white px-4 py-2 rounded">
											{{ $activeApplication->status ? 'Mark as Incomplete' : 'Mark as Completed' }}
										</x-form-button>
									</form>
								</div>
							</div>
						</div>
					@endforeach


				</div>
				@endif
				@if(Auth::user()->usertype==='admin')
					<div>
						<a href="/admin" class="p-2 py-3 rounded-md bg-blue-500 text-gray-100">Go to Dashboard</a>
					</div>
				@endif
			</div>
	</div>
</section>
<x-footer></x-footer>

<script>
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
</body>

</html>
