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
	<script src="https://cdn.tiny.cloud/1/ot6e0um59efmqke5zvj35ugpqo1fhsrai2wmwnwwftxua7wz/tinymce/6/tinymce.min.js"
	        referrerpolicy="origin"></script>
	<title>Create Service</title>
	<script src="https:cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<style>
		body {
			font-family: 'Inter Variable', sans-serif;
		}
	</style>

</head>

<body class="h-full bg-gray-200">
<x-header></x-header>
<section class="mt-[70px] px-3 py-10 w-full flex items-center justify-center">
	<div class=" w-[95%] md:w-1/2 shadow-md px-3 py-4 ">
		<h2 class="text-center text-2xl font-bold leading-tight text-black">
			Create A Service
		</h2>
		<form class="mt-6 w-full" method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
			@csrf
			<div class="space-y-1">
				<div>
					<x-label>Service Title</x-label>
					<x-input type="text" name="title" placeholder="Title" required/>
					<x-form-error name="title"/>
				</div>
				<div>
					<x-label>Service Price</x-label>
					<x-input type="text" name="price" placeholder="Price in USD" required/>
					<x-form-error name="price"/>
				</div>
				<div>
					<x-label>Description</x-label>
					<x-textarea/>
					<x-form-error name="details"/>
				</div>
				<div>
					<x-label>Image</x-label>
					<x-input type="file" name="image"/>
					<x-form-error name="image"/>
				</div>
				<div>
					<x-form-button>
						CREATE SERVICE
					</x-form-button>
				</div>
			</div>
		</form>
	</div>
</section>
<x-scripts></x-scripts>
</body>

</html>
