<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	<title>Chat Room with {{ $user->name }}</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<style>
		body, html {
			margin: 0;
			padding: 0;
			height: 100%;
			overflow: hidden; /* Prevent scrolling of the entire page */
		}

		.chat-container {
			display: flex;
			flex-direction: column;
			height: 100%;
		}

		.chat-header {
			position: fixed; /* Keep the header fixed at the top */
			width: 100%;
			top: 0;
			z-index: 10;
			background-color: #ffffff;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			padding: 1rem;
			height: 64px; /* Fixed height for the header */
		}

		#chat-box {
			flex-grow: 1;
			overflow-y: auto; /* Updated to auto for smooth scrolling */
			padding: 1rem;
			background-color: #f9f9f9;
			margin-top: 64px; /* Space for the fixed header */
		}

		.chat-footer {
			background-color: #ffffff;
			padding: 1rem;
			box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
			position: fixed; /* Ensure the footer stays at the bottom */
			bottom: 0;
			width: 100%;
		}

		textarea {
			resize: none;
		}
	</style>
</head>

<body>
<header class="chat-header">
	<div class="mx-auto flex items-center justify-between">
		<div class="flex items-center">

			<a href="/messages" class="text-gray-500 hover:text-gray-700 mr-3">
				<ion-icon name="chevron-back" size="large"></ion-icon>
			</a>
			<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="{{ $user->name }}"
				class="h-10 w-10 object-cover rounded-full mr-2">
			<div>
				<h1 class="text-lg font-semibold">{{ $user->name }}
					@if($user->verified)
						<ion-icon class="text-blue-500 -ml-1" name="checkmark-done-circle"></ion-icon>
					@endif
				</h1>
				<p class="text-xs flex items-center">
					<ion-icon name="at"></ion-icon>{{ $user->username }}
				</p>
			</div>

		</div>
		@php
			$usertype = $user->usertype;
				    $firstLetter = (substr($usertype, 0, 1)); // Get the first letter and make it uppercase
				    $bgColor = '';

				    // Determine the background color based on usertype
				    switch ($usertype) {
					   case 'freelancer':
						  $bgColor = 'bg-blue-500';
						  break;
					   case 'client':
						  $bgColor = 'bg-green-500';
						  break;
					   case 'system':
						  $bgColor = 'bg-purple-500';
						  break;
					   case 'admin':
						  $bgColor = 'bg-teal-500';
						  break;
					   default:
						  $bgColor = 'bg-gray-200'; // Fallback color
						  break;
				    }
		@endphp

		<span class="{{ $bgColor }} text-white italic font-semibold rounded-full p-1 h-6 w-6 flex items-center justify-center">
			{{ $firstLetter }}
		</span>
	</div>
</header>
<div class="chat-container" id="chat-container">
	<!-- Chat Messages -->
	<div id="chat-box" class="mb-20">
		@foreach ($messages as $message)
			@if ($message->sender_id === auth()->id())
				<div class="flex justify-end mb-2 items-end">
					<div class="bg-blue-400/50 text-black p-2 rounded-2xl rounded-br-none shadow-sm max-w-[80%] w-fit md:max-w-[50%]">
						@if ($message->file)
							@php
								$fileExtension = pathinfo($message->file, PATHINFO_EXTENSION);
							@endphp

							@if (in_array($fileExtension, ['jpeg', 'jpg', 'png', 'gif']))
								<!-- Display image -->
								<img src="{{ asset('storage/messages/' . $message->file) }}" alt="Message Image"
									class="mt-2 max-w-full rounded-lg border border-gray-300" />

							@elseif ($fileExtension === 'pdf')
								<!-- Display PDF -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>

							@elseif (in_array($fileExtension, ['doc', 'docx']))
								<!-- Display Word Document -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-text-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>

							@elseif ($fileExtension === 'rar')
								<!-- Display RAR file -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="library-outline" size="large"></ion-icon>
									<span class="ml-2">Download RAR File</span>
								</a>

							@else
								<!-- Fallback for other file types -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>
							@endif
						@endif

						<p class="text-sm mr-2">{!! nl2br($message->message) !!}</p>
						<div class="flex items-center justify-end">
							<small
								class="block text-right text-[9px]">{{ $message->created_at->format('H:i') }}</small>
							@if ($message->status === 'unread')
								<ion-icon name="checkmark" class="text-gray-600 ml-1"></ion-icon>
							@else
								<ion-icon name="checkmark-done" class="text-blue-700 font-bold ml-1"></ion-icon>
							@endif
						</div>
					</div>
				</div>
			@else
				<div class="flex justify-start mb-2 items-end">
					<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="{{ $user->name }}"
						class="h-8 w-8 object-cover rounded-full mr-2">
					<div class="bg-green-100 text-gray-800 p-2 rounded-2xl rounded-bl-none shadow-sm max-w-[80%] w-fit">
						@if ($message->file)
							@php
								$fileExtension = pathinfo($message->file, PATHINFO_EXTENSION);
							@endphp

							@if (in_array($fileExtension, ['jpeg', 'jpg', 'png', 'gif']))
								<!-- Display image -->
								<img src="{{ asset('storage/messages/' . $message->file) }}" alt="Message Image"
									class="mt-2 max-w-full rounded-lg border border-gray-300" />

							@elseif ($fileExtension === 'pdf')
								<!-- Display PDF -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>

							@elseif (in_array($fileExtension, ['doc', 'docx']))
								<!-- Display Word Document -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-text-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>

							@elseif ($fileExtension === 'rar')
								<!-- Display RAR file -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="library-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>

							@else
								<!-- Fallback for other file types -->
								<a href="{{ asset('storage/messages/' . $message->file) }}" target="_blank"
								   class="flex items-center text-blue-500">
									<ion-icon name="document-outline" size="large"></ion-icon>
									<span class="ml-2">{{$message->file}}</span>
								</a>
							@endif
						@endif
						<p class="text-sm">{!! nl2br($message->message) !!}</p>
						<small
							class="block text-right text-[9px]">{{ $message->created_at->format('H:i') }}</small>
					</div>
				</div>
			@endif
		@endforeach
	</div>

	<!-- Chat Footer -->
	<!-- Chat Footer -->
	<div class="chat-footer">
		@if($user->usertype ==='system')
			<p class="w-full items-center flex justify-center text-red-400 text-base">
				<ion-icon name="ban" size="large" class="text-base"></ion-icon>
				You cant reply to this chat!
			</p>
		@else
			@if ($user->usertype === 'admin' && auth()->id() !== $user->id)
				<div class="p-2 text-red-400 rounded-lg flex items-center justify-center text-lg">
					<ion-icon name="ban" class="text-base"></ion-icon>
					<p class="text-lg">
						You can't message admin
					</p>
				</div>
			@else
				<form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data"
					 class="flex flex-col">
					@csrf
					<input type="hidden" name="receiver_id" value="{{ $user->id }}">

					<div class="flex items-center">
						<label for="file-input" class="cursor-pointer mr-2">
							<ion-icon name="add-circle" class="text-blue-500 text-2xl" size="large"></ion-icon>
						</label>
						<input type="file" name="file" id="file-input" class="hidden"
							  accept="image/*,.pdf,.docx,.rar" />
						<textarea name="message" id="message-input"
								class="flex-grow p-2 rounded-lg border border-gray-300 focus:outline-none resize-none placeholder:italic"
								placeholder="Type your message..." rows="1"></textarea>
						<button type="submit" id="send-button"
							   class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 hidden items-center">
							<ion-icon name="send-outline" class="text-2xl"></ion-icon>
						</button>
						<button type="button" id="clear-file-button" class="ml-2 text-red-500">
							<ion-icon name="trash" class="text-xl"></ion-icon>
						</button>
					</div>

					<!-- Image Preview Container -->
					<div id="image-preview" class="mt-2 flex space-x-2"></div>
				</form>
			@endif
		@endif
	</div>


</div>


<script>
	const fileInput = document.getElementById('file-input')
	const messageInput = document.getElementById('message-input')
	const imagePreviewContainer = document.getElementById('image-preview')
	const sendButton = document.getElementById('send-button')
	const clearFileButton = document.getElementById('clear-file-button')

	// Function to update the UI based on the message and file inputs
	function updateUI() {
		// Hide the send button if both message and file are empty
		if (messageInput.value.trim() === '' && fileInput.files.length === 0) {
			sendButton.classList.add('hidden')
			sendButton.classList.remove('flex')
		} else {
			sendButton.classList.remove('hidden')
			sendButton.classList.add('flex')
		}
	}

	// Function to clear the selected file
	function clearFile() {
		fileInput.value = ''
		imagePreviewContainer.innerHTML = ''
		messageInput.value = ''
		updateUI()
	}

	// File input change event
	fileInput.addEventListener('change', function(event) {
		const file = event.target.files[0]

		// Clear previous file name and preview
		messageInput.value = ''
		imagePreviewContainer.innerHTML = ''

		// Display the file name and preview if it's an image
		if (file) {
			if (file.type.startsWith('image/')) {
				const reader = new FileReader()

				// Preview the image
				reader.onload = function(e) {
					const img = document.createElement('img')
					img.src = e.target.result
					img.className = 'h-32 w-32 object-cover rounded-lg' // Adjust styles as needed
					imagePreviewContainer.appendChild(img)
				}

				reader.readAsDataURL(file)
				messageInput.value = `${file.name}`
			} else {
				const fileIcon = document.createElement('span')
				fileIcon.className = 'text-gray-500' // Adjust styles as needed
				fileIcon.innerText = file.name
				imagePreviewContainer.appendChild(fileIcon)
			}
		}

		updateUI() // Update UI to show/hide the send button
	})

	// Clear file button event
	clearFileButton.addEventListener('click', clearFile)

	// Message input event
	messageInput.addEventListener('input', function() {
		updateUI() // Update UI to show/hide the send button
	})


	function scrollToBottom() {
		const chatBox = document.getElementById('chat-box')
		chatBox.scrollTop = chatBox.scrollHeight
	}

	// Call scrollToBottom when the page loads
	window.onload = function() {
		scrollToBottom()
	}

	// Scroll to bottom when the textarea is focused
	document.getElementById('message-input').addEventListener('focus', scrollToBottom)
</script>
</body>

</html>
