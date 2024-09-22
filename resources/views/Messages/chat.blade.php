<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
			overflow: hidden; /* Prevent content from spilling out */
		}

		.chat-header {
			position: fixed;
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
			overflow-y: auto;
			padding: 1rem;
			background-color: #f9f9f9;
			margin-top: 64px; /* Space for the fixed header */
		}

		.chat-footer {
			background-color: #ffffff;
			padding: 1rem;
			box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
			position: sticky;
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
	<div class="container mx-auto flex items-center justify-between">
		<div class="flex items-center">
			<button onclick="window.history.back()" class="text-gray-500 hover:text-gray-700 mr-3">
				<ion-icon name="chevron-back" size="large"></ion-icon>
			</button>
			<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="{{ $user->name }}"
				class="h-10 w-10 object-cover rounded-full mr-2">
			<div>
				<h1 class="text-lg font-semibold">{{ $user->name }}</h1>
				<p class="text-xs">{{ $user->email }}</p>
			</div>
		</div>
	</div>
</header>
<div class="chat-container" id="chat-container">
	<!-- Chat Messages -->
	<div id="chat-box">
		@foreach ($messages as $message)
			@if ($message->sender_id === auth()->id())
				<div class="flex justify-end mb-2 items-end">
					<div class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md max-w-[60%] w-fit">
						<p class="text-sm">{{ $message->message }}</p>
						<small class="block text-right text-xs">{{ $message->created_at->format('H:i') }}</small>
					</div>
					<img src="{{ asset('storage/avatars/' . auth()->user()->photo) }}"
						alt="{{ auth()->user()->name }}"
						class="h-8 w-8 object-cover rounded-full ml-2">
				</div>
			@else
				<div class="flex justify-start mb-2 items-end">
					<img src="{{ asset('storage/avatars/' . $user->photo) }}" alt="{{ $user->name }}"
						class="h-8 w-8 object-cover rounded-full mr-2">
					<div class="bg-gray-300 text-gray-800 p-2 rounded-lg shadow-md max-w-[60%] w-fit">
						<p class="text-sm">{{ $message->message }}</p>
						<small
							class="block text-left text-[8px]">{{ $message->created_at->format('H:i') }}</small>
					</div>
				</div>
			@endif
		@endforeach
	</div>

	<!-- Chat Footer -->
	<footer class="chat-footer">
		<form action="{{ route('messages.store') }}" method="POST" class="flex">
			@csrf
			<input type="hidden" name="receiver_id" value="{{ $user->id }}">
			<textarea name="message" id="message-input"
					class="w-full p-2 rounded-lg border border-gray-300 focus:outline-none resize-none"
					placeholder="Type your message..." rows="1"></textarea>
			<button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
				Send
			</button>
		</form>
	</footer>

</div>

<script>
	function setChatContainerHeight() {
		const chatContainer = document.getElementById('chat-container')
		const headerHeight = document.querySelector('.chat-header').offsetHeight
		const footerHeight = document.querySelector('.chat-footer').offsetHeight

		// Set chat container height based on the available visual viewport height
		if (window.visualViewport) {
			const viewportHeight = window.visualViewport.height
			chatContainer.style.height = `${viewportHeight - headerHeight - footerHeight}px`
		} else {
			// Fallback for browsers that don't support visualViewport
			const windowHeight = window.innerHeight
			chatContainer.style.height = `${windowHeight - headerHeight - footerHeight}px`
		}
	}

	function scrollToBottom() {
		const chatBox = document.getElementById('chat-box')
		chatBox.scrollTop = chatBox.scrollHeight
	}

	// Call setChatContainerHeight when the page loads and on window resize
	window.onload = function() {
		setChatContainerHeight()
		scrollToBottom()
	}

	// Adjust the chat container height on viewport change (keyboard opening)
	if (window.visualViewport) {
		window.visualViewport.addEventListener('resize', setChatContainerHeight)
	}

	// Scroll to bottom when the textarea is focused
	document.getElementById('message-input').addEventListener('focus', scrollToBottom)
</script>
</body>

</html>
