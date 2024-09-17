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
	<title>Register</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="h-full font-inter">
<div class="flex h-full items-center justify-center bg-gray-200 px-3 py-6 sm:py-6 lg:px-4 lg:py-4">
	<div class="mt-4 w-[95%] mx-auto md:w-3/5 lg:w-1/2 p-4 shadow-md  bg-white rounded-lg">
		<h2 class="text-center text-xl md:text-2xl font-bold leading-tight text-black">
			Sign up for an Account
		</h2>
		<form class="my-3" method="POST" action="/register" enctype="multipart/form-data">
			@csrf
			<div class="space-y-2 md:space-y-3">
				<div>
					<x-input type="text" name="name" placeholder="Your Full Name" />
					<x-form-error name="name" />
				</div>
				<div>
					<x-input type="email" name="email" placeholder="Email Address" />
					<x-form-error name="email" />
				</div>
				<div>
					<x-label class="italic">Registering as?</x-label>
					<select name="usertype" id="usertype"
						   class="w-full rounded-md bg-gray-300 px-3 py-2 text-sm font-medium ">
						<option class="text-sm italic" value="" selected disabled>Select who you want to be
						</option>
						<option class="text-sm italic" value="client">Client</option>
						<option class="text-sm italic" value="freelancer">Freelancer</option>
					</select>
					<x-form-error name="usertype" />
				</div>
				<div>
					<x-input type="password" name="password" placeholder="Password" />
					<x-form-error name="password" />
				</div>
				<div>
					<x-input type="password" name="password_confirmation" placeholder="Confirm Password" />
					<x-form-error name="password_confirmation" />
				</div>
				<div>
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

						<input id="file-upload" type="file" name="photo" class="hidden" />
						<p id="file-name" class="text-sm text-gray-600"></p>
					</div>
					<x-form-error name="photo" />
				</div>
				<div class="mt-2 w-full">
					<x-form-button>
						Register
					</x-form-button>
				</div>
				<p class="mt-1 text-center text-xs md:text-sm text-gray-600">
					Have an account? <a href="/login" class="text-blue-500 underline">Login here</a>
				</p>
			</div>
		</form>
	</div>
</div>
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
