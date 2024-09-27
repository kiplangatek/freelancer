<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/ui/apple-touch-icon.png') }}">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/ui/favicon-32x32.png') }}">
	<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/ui/favicon-16x16.png') }}">
	<link rel="manifest" href="{{ asset('storage/ui/site.webmanifest') }}">
	<title>Messages</title>
	@vite(['resources/css/app.css'])
	<script src="https://cdn.tailwindcss.com"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<style>
		.floating-button {
			position: fixed;
			bottom: 20px;
			right: 20px;
			background-color: #3B82F6; /* Tailwind blue-500 */
			color: white;
			border-radius: 50%;
			width: 56px;
			height: 56px;
			display: flex;
			justify-content: center;
			align-items: center;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			cursor: pointer;
			z-index: 50; /* Ensure it appears above other elements */
		}

		.floating-button-label {
			position: fixed;
			bottom: 80px; /* Space above the button */
			right: 20px; /* Align with the button */
			background-color: white;
			color: #3B82F6; /* Tailwind blue-500 */
			border-radius: 8px;
			padding: 5px 10px;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			z-index: 50; /* Ensure it appears above other elements */
			white-space: nowrap; /* Prevent text wrapping */
		}
	</style>
</head>
<body class="font-inter">

<div class="container mx-auto py-4 px-4">
	<div class="flex items-center mb-6">
		<a href="/my" class="text-gray-500 text-xl hover:text-gray-700 mr-3">
			<ion-icon name="chevron-back" size="large"></ion-icon>
		</a>
		<h1 class="text-3xl font-black text-gray-800">Chats</h1>
	</div>
	<div>
		<input type="search"
			  class="mb-6 py-4 px-3 h-12 w-full rounded-2xl items-center border border-gray-100 bg-gray-200 outline-0 placeholder:italic"
			  placeholder="Search through your chats...." />
	</div>

	@php
		// Sort chats to ensure the user's own messages appear first
		  $sortedChats = $chats->sortByDesc(function($messages, $chatWithUserId) {
			 $chatUser = $messages->first()->sender_id === auth()->id() ? $messages->first()->receiver : $messages->first()->sender;
			 return $chatUser->id === auth()->id() ? 1 : 0; // Put your own messages first
		  });

		  // Check if the user has any messages where they are both sender and receiver
		  $selfChatExists = $chats->contains(function($messages) {
			  return $messages->first()->sender_id === auth()->id() && $messages->first()->receiver_id === auth()->id();
		  });
	@endphp

	@forelse ($sortedChats as $chatWithUserId => $messages)
		@php
			$chatUser = $messages->first()->sender_id === auth()->id() ? $messages->first()->receiver : $messages->first()->sender;
			   $lastMessage = $messages->last(); // Get the latest message
			   $unreadCount = $unreadCounts[$chatWithUserId] ?? 0;
		@endphp
		<a href="{{ route('chat.show', $chatUser->id) }}"
		   class="bg-white p-3 border-b border-gray-300 flex items-center justify-between transition duration-300 ease-in-out hover:bg-gray-100">
			<div class="flex items-center">
				<!-- User Image -->
				<img src="{{ asset('storage/avatars/' . $chatUser->photo) }}" alt="{{ $chatUser->name }}"
					class="h-10 w-10 object-cover rounded-full mr-4">
				<div class="flex-1">
					<div class="flex items-center justify-between">
						<h2 class="text-base font-bold text-gray-800">
							{{ $chatUser->name }}
							@if($chatUser->id === auth()->id())
								(You)
							@elseif($chatUser->verified)
								<ion-icon class="text-blue-400 -ml-1" name="checkmark-circle"></ion-icon>
							@endif
						</h2>
					</div>
					<p class="flex items-center text-sm text-gray-600 w-56 {{ $lastMessage->status === 'unread' && $lastMessage->sender_id !== auth()->id() ? 'font-bold' : '' }}">
						<!-- Display checkmark icons only if the last message is from the authenticated user -->
						@if ($lastMessage->sender_id === auth()->id())
							@if ($lastMessage->status === 'unread')
								<ion-icon name="checkmark"
										class="text-gray-500 font-bold mr-1 flex-shrink-0"></ion-icon>
							@else
								<ion-icon name="checkmark-done"
										class="text-green-500 text-lg mr-1 flex-shrink-0"></ion-icon>
							@endif
						@endif

						<!-- Conditionally display the attachment icon if the last message contains a file -->
						@if ($lastMessage->file)
							<ion-icon name="attach-outline"
									class="text-gray-600 text-base flex-shrink-0"></ion-icon>
						@endif
						<!-- Display the last message text -->
						<span class="truncate text-gray-800 font-normal">{{$lastMessage->file}} &nbsp; {!! nl2br($lastMessage->message) !!}
					</span>
					</p>
				</div>
			</div>
			<div class="text-right flex flex-col items-end justify-between">
				<!-- Message Time -->
				<p class="text-xs {{$unreadCount > 0 ? 'text-green-500' : 'text-gray-400'}}">
					@php
						$now = \Carbon\Carbon::now();
							 $yesterday = $now->copy()->subDay()->startOfDay();
							 if ($lastMessage->created_at >= $now->startOfDay()) {
								echo $lastMessage->created_at->format('H:i'); // Show time if today
							 } elseif ($lastMessage->created_at >= $yesterday) {
								echo 'Yesterday'; // Show 'Yesterday' if from yesterday
							 } else {
								echo $lastMessage->created_at->format('m/d/Y'); // Format for older dates
							 }
					@endphp
				</p>

				<!-- Unread Count Below the Time -->
				@if ($unreadCount > 0)
					<span
						class="bg-green-500 text-white text-xs font-bold rounded-full h-6 min-w-6 w-fit px-2 py-1 mt-1 flex items-center justify-center">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
				@else
					<span class="text-transparent">0</span>
				@endif
			</div>
		</a>
	@empty
		<p class="text-center text-gray-500">You have no active chats.</p>
	@endforelse

	<!-- Floating Button for Messaging Yourself -->
	@if (!$selfChatExists)
		<a href="{{ route('chat.show', auth()->id()) }}" class="floating-button">
			<ion-icon name="add-circle" size="large"></ion-icon>
		</a>
		<!-- Label for the Floating Button -->
		<div class="floating-button-label">
			Message Yourself
		</div>
	@endif

</div>

</body>
</html>
