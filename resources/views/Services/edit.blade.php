<!doctype html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit | {{$service->title}}</title>
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">

	@vite(['resources/css/app.css'])
	<script src="https://cdn.tiny.cloud/1/ot6e0um59efmqke5zvj35ugpqo1fhsrai2wmwnwwftxua7wz/tinymce/6/tinymce.min.js"
		   referrerpolicy="origin"></script>
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body class="h-full bg-gray-100 font-sans">
<x-header></x-header>
<section class="mt-24 px-4 py-10 flex items-center justify-center">
	<div class="w-full max-w-lg bg-white shadow-lg rounded-lg p-6">
		<h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">
			Edit Service
		</h2>
		<form class="space-y-6" method="POST" action="/services/{{$service->id}}" enctype="multipart/form-data">
			@csrf
			@method('PATCH')
			<div>
				<x-label for="title" class="text-gray-700">Service Title</x-label>
				<x-input type="text" id="title" name="title" placeholder="Title" value="{{$service->title}}"
					    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
					    required />
				<x-form-error name="title" />
			</div>
			<div>
				<x-label for="price" class="text-gray-700">Service Price</x-label>
				<x-input type="text" id="price" name="price" placeholder="Price in USD" value="{{$service->price}}"
					    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
					    required />
				<x-form-error name="price" />
			</div>
			<div>
				<x-label for="details" class="text-gray-700">Description</x-label>
				<x-textarea id="details" name="details"
						  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
						  placeholder="Enter service description..." required>{{ $service->details }}</x-textarea>
				<x-form-error name="details" />
			</div>
			<div class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50"
				id="drop-area">
				<div class="mb-2">
					<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-500" viewBox="0 0 512 512">
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
                        <span class="font-semibold text-blue-600 cursor-pointer"
						id="upload-trigger">Upload a file</span>
					or drag and drop
				</p>
				<p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
				<input id="file-upload" type="file" name="image" class="hidden" />
				<p id="file-name" class="text-sm text-gray-600"></p>
			</div>
			<x-form-error name="image" />
			<div>
				<x-form-button
					class="w-full bg-blue-600 text-white py-2 px-4 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
					EDIT SERVICE
				</x-form-button>
			</div>
		</form>
	</div>
</section>

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
<x-scripts></x-scripts>
</body>

</html>
