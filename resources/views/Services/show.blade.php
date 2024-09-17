<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $service->title }}</title>
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="40x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="20x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	@vite(['resources/css/app.css'])
	<script src="https:cdn.tailwindcss.com"></script>
	<script src="https://unpkg.com/alpinejs" defer></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="h-full w-full bg-gray-200">
<x-header></x-header>
<section class="body-font mt-14 w-full items-center px-6 py-10">
	<div id="banner"
		class="fixed left-1/2 top-0 z-40 mt-[100px] flex w-[90%] -translate-x-1/2 transform items-center gap-1 transition-all duration-300 md:mt-[110px]">
		<div>
			<a href="javascript:history.back()"
			   class="flex h-14 w-fit items-center rounded-lg bg-blue-200 bg-opacity-60 px-1 text-lg font-bold backdrop-blur-lg hover:bg-opacity-70 md:h-16">
				<ion-icon class="mx-1 text-2xl" name="chevron-back-circle-outline"></ion-icon>
				<span class="hidden md:block">Back</span>
			</a>
		</div>
		<div
			class="flex h-14 flex-1 items-center justify-between rounded-lg bg-blue-200 bg-opacity-70 px-2 backdrop-blur-lg md:h-16">
			<div class="flex items-center text-[16px] font-semibold md:text-xl">
				{{ $service->title }}
			</div>
			<div class="mr-1.5">
				@if (Auth::check())
					@can('edit', $service)
						<!-- Show Edit button for the freelancer who owns the service -->
						<a href="/services/{{ $service->id }}/edit"
						   class="rounded-md bg-blue-700 bg-opacity-70 px-3.5 py-2.5 backdrop-blur-lg hover:bg-blue-500 hover:bg-opacity-70 hover:backdrop-blur-lg">
							Edit
						</a>
					@endcan
					@can('apply', $service)
						<!-- Show Apply button for clients -->
						<button onclick="showDialog()"
							   class="rounded-md bg-blue-700 bg-opacity-70 px-2 py-1 backdrop-blur-lg hover:bg-blue-500 hover:bg-opacity-70 hover:backdrop-blur-lg md:px-3 md:py-2">
							Apply
						</button>
					@endcan
				@endif
			</div>
		</div>
	</div>
	@if (session('success'))
		<div class="container relative mt-16">
			<x-alert type="success" :message="session('success')" />
		</div>
	@endif

	@if (session('error'))
		<div class="container relative mt-20">
			<x-alert type="error" :message="session('error')" />
		</div>
	@endif
	@if ($errors->has('apply'))
		<div class="container relative mt-16">
			<x-alert type="warning" :message="$errors->first('apply')" />
		</div>
	@endif
	<div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true">
		<div id="bg" class="fixed inset-0 hidden bg-gray-500 bg-opacity-90 transition-opacity"
			aria-hidden="true"></div>

		<div id="dialog"
			class="fixed inset-0 z-10 hidden w-screen overflow-y-auto opacity-0 transition-opacity duration-500">
			<div class="flex min-h-full items-center justify-center p-4 text-center sm:items-center sm:p-0">
				<div
					class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
					<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
						<div class="sm:flex sm:items-start">
							<div
								class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-300 sm:mx-0 sm:h-10 sm:w-10">
								<svg width="24px" xmlns="http://www.w3.org/2000/svg" class="ionicon"
									viewBox="0 0 512 512">
									<path fill="none" stroke="currentColor" stroke-linecap="round"
										 stroke-linejoin="round" stroke-width="30"
										 d="M320 264l-89.6 112-38.4-44.88" />
									<path fill="none" stroke="currentColor" stroke-linecap="round"
										 stroke-linejoin="round" stroke-width="30"
										 d="M80 176a16 16 0 00-16 16v216c0 30.24 25.76 56 56 56h272c30.24 0 56-24.51 56-54.75V192a16 16 0 00-16-16zM160 176v-32a96 96 0 0196-96h0a96 96 0 0196 96v32" />
								</svg>
							</div>
							<div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
								<h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">
									{{ $service->title }}</h3>
								<h4 class="text-md font-bold leading-6 text-gray-900">
									Ksh. {{ number_format($service->price)}}</h4>
								<div class="mt-2">
									<p class="text-sm text-gray-500">Are you sure you want to apply for
										this?<br>
										To check your application visit your dashboard.</p>
								</div>
							</div>
						</div>
					</div>
					<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
						<form action="{{ route('applications.apply') }}" method="post">
							@csrf
							<input type="hidden" name="service_id" value="{{ $service->id }}">
							<button type="submit"
								   class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">
								Apply
							</button>
						</form>

						<button type="button" onclick="hideDialog()"
							   class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
							Cancel
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="mt-16 flex items-center justify-center py-2 ">
		<div class="flex w-full max-w-4xl flex-col items-center space-y-3 rounded-lg p-3">
			<div class="relative h-48 w-full overflow-hidden rounded-xl md:h-60">
				<img class="h-full w-full object-cover" src="{{ asset('storage/services/' . $service->image) }}"
					alt="{{ $service->title }}" />
				<!-- Price tag as an overlay on the image -->
				<div
					class="absolute right-2 top-2 rounded-lg bg-blue-200 bg-opacity-70 px-3 py-1 text-lg font-bold text-black backdrop-blur-lg md:text-xl">
					Ksh. {{ number_format($service->price) }}
				</div>
			</div>
		</div>
	</div>
	<div class=" p-2 flex items-end flex-row-reverse ">
		<a href="/freelancer/{{$service->freelancer->id}}">
			<img class="h-9 w-9 rounded-full justify-end"
				src="{{asset('storage/avatars/'. $service->freelancer->photo)}}"
				alt="{{$service->freelancer->name}}">
		</a>
	</div>
	<div class="mb-8 space-y-2 rounded-lg px-3 shadow-lg md:px-14 py-4">
		<h2 class="mt-1 text-2xl font-bold italic underline">About this service</h2>
		<div class="mb-5 space-y-1 px-3 pb-2.5 text-sm md:text-xl">
			{!! $service->details !!}
		</div>
		<a href="/services?category={{$service->category->id}}"
		   class="rounded-3xl px-3 py-2 text-sm bg-blue-300 shadow-md w-fit mb-3  mt-2 hover:bg-blue-400">{{$service->category->name}}</a>
	</div>
</section>
<x-footer></x-footer>
<x-scripts></x-scripts>
<script type="text/javascript">
	function showDialog() {
		let dialog = document.getElementById('dialog')
		let bg = document.getElementById('bg')
		dialog.classList.remove('hidden')
		bg.classList.remove('hidden')
		body.classList.toggle('overflow-hidden')
		setTimeout(() => {
			dialog.classList.add('opacity-100')
			bg.classList.add('opacity-90')
		}, 70)
	}

	function hideDialog() {
		let dialog = document.getElementById('dialog')
		let bg = document.getElementById('bg')
		dialog.classList.add('hidden')
		bg.classList.add('hidden')
		body.classList.toggle('overflow-hidden')
		setTimeout(() => {
			dialog.classList.add('opacity-0')
			bg.classList.add('opacity-0')
		}, 50)
	}
</script>
</body>

</html>
