<!doctype html>
<html lang="en" class="h-full bg-gray-100">

<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		 content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">

	<title>Login</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class=" h-full font-inter bg-gray-200">
<div class="flex h-full items-center justify-center bg-white px-4 py-10  sm:py-16 lg:px-8 lg:py-8">
	<div class="mt-8 w-[93%] mx-auto md:w-1/3  p-4 shadow-md  xl:w-full xl:max-w-sm 2xl:max-w-md">
		<div class="mb-2 flex justify-center "></div>
		<h2 class="text-center text-[26px] font-bold leading-tight">
			Sign in to your Account
		</h2>
		<form method="POST" action="{{ route('login') }}" class="mt-8">
			@csrf
			<div class="space-y-3">
				<div>
					<div class="relative">
						<ion-icon name="mail-outline" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></ion-icon>
						<x-input type="email" name="email" placeholder="Email Address" class="pl-10" />
						<x-form-error name="email" />
					</div>
					@if ($errors->any())
						<div class="mt-0.5 text-sm font-medium italic text-red-500">
							@foreach ($errors->all() as $error)
								<p>{{ $error }}</p>
							@endforeach
						</div>
					@endif
				</div>
				<div class="relative">
					<x-label>Password</x-label>
					<x-input type="password" id="password" name="password" placeholder="Password" class="pr-10" />
					<ion-icon id="togglePassword" name="eye-outline"
						class="absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-500 text-xl"  ></ion-icon>

					<a class="text-sm font-semibold text-blue-500 hover:underline mt-1 block" href="/forgot-password">
						Forgot password?
					</a>
					<x-form-error name="password" />
				</div>


				<div>
					<x-form-button>
						Login
					</x-form-button>
				</div>
				<p class="mt-1 text-center text-sm text-gray-600">
					New here? <a href="/register" class="text-blue-500 underline">Create a free account</a>
				</p>
			</div>
		</form>

	</div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute between 'password' and 'text'
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        // Change the icon accordingly
        this.setAttribute('name', type === 'password' ? 'eye-outline' : 'eye-off-outline');
    });
</script>


</body>

</html>
