<!doctype html>
<html lang="en" data-bs-theme-mode="system">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">

	<title>My Services</title>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="h-full bg-gray-200">
<x-header></x-header>
<div class="container mx-auto p-4 mt-20 mb-10">
	<h1 class="text-2xl font-bold mb-4">My Services</h1>
	<div class="grid gap-0.5 md:gap-6 mx-auto grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2">
		@foreach($services as $service)
			<div id="dialog-bg-{{ $service->id }}"
			     class="fixed inset-0 bg-gray-500 bg-opacity-90 transition-opacity hidden"
			     aria-hidden="true"></div>

			<div id="dialog-{{ $service->id }}"
			     class="fixed inset-0 z-10 w-screen overflow-y-auto hidden opacity-0 transition-opacity duration-500">
				<div
					class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
					<div
						class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
						<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
							<div class="sm:flex sm:items-start">
								<div
									class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-400 sm:mx-0 sm:h-10 sm:w-10">
									<svg width="25px" xmlns="http://www.w3.org/2000/svg" class="ionicon"
									     viewBox="0 0 512 512">
										<path
											d="M112 112l20 320c.95 18.49 14.4 32 32 32h184c17.67 0 30.87-13.51 32-32l20-320"
											fill="none" stroke="currentColor" stroke-linecap="round"
											stroke-linejoin="round" stroke-width="32"/>
										<path stroke="currentColor" stroke-linecap="round"
										      stroke-miterlimit="10"
										      stroke-width="30" d="M80 112h352"/>
										<path
											d="M192 112V72h0a23.93 23.93 0 0124-24h80a23.93 23.93 0 0124 24h0v40M256 176v224M184 176l8 224M328 176l-8 224"
											fill="none" stroke="currentColor" stroke-linecap="round"
											stroke-linejoin="round" stroke-width="30"/>
									</svg>
								</div>
								<div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
									<h3 class="text-base font-semibold leading-6 text-gray-900"
									    id="modal-title">{{ $service->title }}</h3>
									<h4 class="text-md font-bold leading-6 text-gray-900">{{ $service->price }}</h4>
									<div class="mt-2">
										<h4 class="font-semibold text-lg"> Are you sure you want to delete
											this?</h4>
										<p class="text-sm text-gray-500">Check first if there are any active
											applications.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
							<button type="button"
							        class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
								Delete
							</button>
							<button type="button" onclick="hideDialog('dialog-{{ $service->id }}')"
							        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
								Cancel
							</button>
						</div>
					</div>
				</div>
			</div>
			<div class="p-4">
				<div class="bg-gray-100 rounded-lg overflow-hidden shadow-lg">
					<div class="w-full h-[150px] md:h-[200px] lg:max-h-60 bg-red-100">
						<img class="w-full h-full object-cover"
						     src="{{ asset('storage/services/' . $service->image) }}"
						     alt="{{ $service->title }}">
					</div>
					<div class="px-2 py-4">
						<div class="flex justify-between">
							<h3 class="text-gray-700 text-[13px] font-semibold md:text-sm md:font-medium">{{ $service->title }}</h3>
							<h3 class="text-gray-800 text-[13px] md:text-sm font-medium bg-green-300 p-1 rounded-md">{{ $service->price }}</h3>
						</div>
						<div class="flex justify-between items-center mt-4">
							<a href="{{ route('services.show', $service->id) }}"
							   class="flex-1 inline-block px-4 py-2 text-white bg-black rounded-md text-center">
								View Service
							</a>
							<button type="button" onclick="showDialog('dialog-{{ $service->id }}')"
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
<x-footer></x-footer>
<x-scripts></x-scripts>
</body>
</html>
