<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">

	@vite(['resources/css/app.css'])
	<script src="https:cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="h-full bg-gray-300">

<x-header></x-header>
<section class="mt-14 px-5 py-10">

	<h1>Welcome to the Client Dashboard, {{ $user->name }}!</h1>

	<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="Profile Image"
	     style="width: 150px; height: 150px; border-radius: 50%;">

	<p>Your email: {{ $user->email }}</p>
	<p>Your user type: {{ $user->usertype }}</p>

</section>
<x-scripts></x-scripts>
</body>
</html>
