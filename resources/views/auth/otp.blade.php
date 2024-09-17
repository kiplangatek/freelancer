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

	<title>Verify OTP</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

		body {
			font-family: 'Inter', sans-serif;
		}

		/* Hide the spinner (arrows) in number input fields on Chrome, Safari, Edge, and Opera */
		input[type="number"]::-webkit-outer-spin-button,
		input[type="number"]::-webkit-inner-spin-button {
			-webkit-appearance: none;
			margin: 0;
		}

		/* Hide the spinner (arrows) on Firefox */
		input[type="number"] {
			-moz-appearance: textfield;
		}

	</style>
</head>
<body class="bg-gray-100 h-screen px-5 flex justify-center items-center">
<div class="bg-white px-8 py-8 rounded-lg shadow-lg w-full max-w-md">
	<h2 class="text-2xl font-bold mb-6">OTP Verification</h2>

	<!-- Display errors if any -->
	@if($errors->any())
		<div class="bg-red-100 text-red-700 p-4 rounded mb-4">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<form method="POST" action="{{ route('otp.verify') }}">
		@csrf
		<div class="mb-1">
			<x-label for="otp" class="block text-sm font-medium text-gray-700">Enter OTP</x-label>
			<x-input type="number" name="otp" maxlength="6" id="otp" min="100000" max="999999"
			         oninput="validateNumberInput(this)"
			         required/>
		</div>
		<!-- Set the email from session -->
		<x-input type=" hidden
			" name="email" value="{{ session('email') }}"/>

		<div>
			<x-form-button class="px-3 py-2 mt-0.5" type="submit">
				Verify
			</x-form-button>
		</div>
	</form>

	<form method="POST" action="{{ route('otp.resend') }}" class="mt-1 text-left">
		@csrf
		<!-- Set the email from session directly in the resend form -->
		<x-input type="hidden" name="email" value="{{ session('email') }}"/>
		<button type="submit" class="text-blue-600 hover:underline bg-transparent outline-none italic"
		        id="resendOtpBtn">
			Resend OTP
		</button>
	</form>
</div>

<script>
	// Prevent non-numeric input (except digits)
	function validateNumberInput(input) {
		input.value = input.value.replace(/[^0-9]/g, ''); // Replace non-numeric characters

		if (input.value.length > 6) {
			input.value = input.value.slice(0, 6);
		}
	}
</script>
</body>
</html>
