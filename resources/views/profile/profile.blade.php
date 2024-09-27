<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Profile</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://unpkg.com/alpinejs" defer></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-900 font-inter">
<div class="mx-auto w-full h-screen bg-white ">
	<div class="bg-gray-200 flex items-center h-fit py-4 px-5 sticky t-0 l-0 w-full">
		<a href="{{ route('services.my') }}" class="inline-flex items-center text-blue-500 hover:text-blue-700 py-2 ">
			<ion-icon name="chevron-back-outline" class="mr-1 text-lg" size="large"></ion-icon>
			Back
		</a>

		<h1 class="text-3xl font-black text-black text-center ml-4 py-2 ">Edit Profile</h1>
	</div>

	@if (session('success'))
		<div class="mb-4">
			<x-alert type="success" :message="session('success')" />
		</div>
	@endif
	<form action="{{ route('profile.edit', $user->id) }}" method="POST" enctype="multipart/form-data"
		 class="space-y-4 px-6 py-4">
		@csrf
		@method('PATCH')

		<div class="flex  mb-4">
			@if ($user->photo)
				<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="Profile Image"
					class="w-28 h-28 rounded-full object-cover border-2 border-blue-500">
			@endif
		</div>
		<div class="space-y-3">
			<div>
				<label for="name" class="block text-sm font-medium text-gray-700">Name</label>
				<input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
					  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm">
				<x-form-error name="name" />
			</div>
			<div>
				<label for="username" class="block text-sm font-medium text-gray-700">Username</label>
				<input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
					  pattern="[a-zA-Z0-9]+" title="Username can only contain letters and numbers"
					  class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm">
				<x-form-error name="username" />
			</div>
			<div>
				<label for="photo" class="block text-sm font-medium text-gray-700">Profile Image</label>
				<div class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50"
					id="drop-area">
					<div class="mb-2">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400"
							viewBox="0 0 512 512">
							<rect x="48" y="80" width="416" height="352" rx="48" ry="48" fill="none"
								 stroke="currentColor" stroke-linejoin="round" stroke-width="32" />
							<circle cx="336" cy="176" r="32" fill="none" stroke="currentColor"
								   stroke-miterlimit="10" stroke-width="32" />
							<path
								d="M304 335.79l-90.66-90.49a32 32 0 00-43.87-1.3L48 352M224 432l123.34-123.34a32 32 0 0143.11-2L464 368"
								fill="none" stroke="currentColor" stroke-linecap="round"
								stroke-linejoin="round"
								stroke-width="32" />
						</svg>
					</div>

					<p class="mb-1 text-sm text-gray-600">
						<span class="font-semibold text-blue-600 cursor-pointer"
							 id="upload-trigger">Upload a file</span>
						or drag and drop
					</p>
					<p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>

					<input id="file-upload" type="file" name="photo" class="hidden" />
					<p id="file-name" class="text-sm text-gray-600 mt-2"></p>
				</div>
				<x-form-error name="photo" />
			</div>
		</div>
		<div class="text-center">
			<button type="submit"
				   class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-500 px-6 py-3 text-sm font-medium text-white shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
				Update Profile
			</button>
		</div>
	</form>
	<div class="px-3">
		<p class="text-base font-inter font-medium italic">To change your password, logout and click on the
			forgot password on the login page.!
		</p>
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
