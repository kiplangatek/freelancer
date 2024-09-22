<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Messages</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

<div class="container mx-auto py-4 px-4">
	<div class="flex items-center mb-6">
		<button onclick="window.history.back()" class="text-gray-500 text-xl hover:text-gray-700 mr-3">
			<ion-icon name="chevron-back" size="large"></ion-icon>
		</button>
		<h1 class="text-2xl font-bold text-gray-800">Your Chats</h1>
	</div>
	<div>
		<x-input type="search" class="mb-4 py-3 h-10" placeholder="Search through your chats...." />
	</div>
	@forelse ($chats as $chatWithUserId => $messages)
		@php
			$chatUser = $messages->first()->sender_id === auth()->id() ? $messages->first()->receiver : $messages->first()->sender;
		@endphp
		<a href="{{ route('chat.show', $chatUser->id) }}"
		   class="block bg-white p-4 mb-4 rounded-lg shadow-md flex items-center justify-between transition duration-300 ease-in-out hover:bg-gray-100">
			<div class="flex items-center">
				<!-- User Image -->
				<img src="{{ asset('storage/avatars/' . $chatUser->photo) }}" alt="{{ $chatUser->name }}"
					class="h-12 w-12 object-cover rounded-full mr-4">
				<div>
					<h2 class="text-lg font-bold text-gray-800">{{ $chatUser->name }}</h2>
					<p class="text-sm text-gray-600 truncate w-56">
						 <span
							 class="text-gray-800 font-medium">{{ $messages->last()->message }}</span>
					</p>
					<p class="text-xs text-gray-400">
						{{ $messages->last()->created_at->format('H:i')}}
					</p>
				</div>
			</div>
			<!-- Optional Icon or Additional Information -->
			<ion-icon name="chatbubble-outline" class="text-blue-500 text-2xl"></ion-icon>
		</a>
	@empty
		<p class="text-center text-gray-500">You have no active chats.</p>
	@endforelse
</div>

</body>
</html>
