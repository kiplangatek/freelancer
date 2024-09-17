<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		 content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<script src="https://unpkg.com/alpinejs" defer></script>

	<title>Forgot Password</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

		body {
			font-family: 'Inter', sans-serif;
		}
	</style>
</head>

<body class="flex h-screen items-center justify-center bg-gray-100 px-5">
<div class="w-full max-w-md rounded-lg bg-white px-8 py-8 shadow-lg">
	<h2 class="mb-6 text-2xl font-bold">Password Reset</h2>

	@if ($errors->any())
		<div class="mb-2 rounded bg-red-100 p-4 text-red-700">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	@if (session('status'))
		<x-alert type="success" :message="session('status')" />
	@endif
	<form method="POST" action="{{ route('password.email') }}" class="space-y-6">
		@csrf
		<div>
			<label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
			<input type="email" name="email" id="email" required
				  class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-blue-500 sm:text-sm">
		</div>
		<button type="submit"
			   class="flex w-full justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
			Send Password Reset Link
		</button>
	</form>
</div>

</body>

</html>
