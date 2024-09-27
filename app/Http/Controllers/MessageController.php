<?php

	namespace App\Http\Controllers;

	use App\Models\Message;
	use App\Models\User;
	use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

	class MessageController extends Controller
	{
		public function index()
		{
			// Fetch all unique chat users for the authenticated user
			$userId = Auth::user()->id;

			$chats = Message::where('sender_id', $userId)
				->orWhere('receiver_id', $userId)
				->with(['sender', 'receiver'])
				->get()
				->groupBy(function ($message) use ($userId) {
					// Group messages by the user ID of the other person
					return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
				});

			// Sort the chats by the latest message's created_at in descending order
			$chats = $chats->sortByDesc(function ($messages) {
				return $messages->last()->created_at;
			});

			// Count unread messages for each chat
			$unreadCounts = $chats->mapWithKeys(function ($messages, $chatWithUserId) use ($userId) {
				$unreadCount = $messages->where('receiver_id', $userId)->where('status', 'unread')->count();
				return [$chatWithUserId => $unreadCount];
			});

			return view('messages.index', compact('chats', 'unreadCounts'));
		}

		public function show(User $user)
		{
			$userId = Auth::user()->id;
			// Mark all unread messages where the current user is the receiver as 'read'
			Message::where('sender_id', $user->id)
				->where('receiver_id', $userId)
				->where('status', 'unread')
				->update(['status' => 'read']);

			// Show the chat messages between the selected user
			$messages = Message::where(function ($query) use ($userId, $user) {
				$query->where('sender_id', $userId)->where('receiver_id', $user->id);
			})
				->orWhere(function ($query) use ($userId, $user) {
					$query->where('sender_id', $user->id)->where('receiver_id', $userId);
				})
				->orderBy('created_at', 'asc')  // Order by ascending to show older messages first
				->get();

			return view('messages.chat', compact('messages', 'user'));
		}

		public function store(Request $request)
		{
			// Validate the input
			$request->validate([
				'receiver_id' => 'required|exists:users,id',
				'message' => 'nullable|string|max:100000',
				'file' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,doc,docx,rar|max:5120',
			]);

			// Create a new message instance
			$message = new Message();
			$message->sender_id = Auth::user()->id;
			$message->receiver_id = $request->receiver_id;

			// Handle the uploaded file, if present
			if ($request->hasFile('file')) {
				$file = $request->file('file');

				// Determine file name based on file type
				if (in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif'])) {
					// For image files, use the timestamp as the filename
					$timestamp = now()->format('YmdHis');
					$filename = "{$timestamp}.{$file->getClientOriginalExtension()}";
				} else {
					// For other file types, use the original name
					$filename = $file->getClientOriginalName();
				}

				// Store the file
				$file->storeAs('messages', $filename, 'public');
				$message->file = $filename;
			}

			// Save the message text if available
			if ($request->message) {
				$message->message = $request->message;
			}

			// Ensure at least a message or a file is provided before saving
			if ($message->message || $message->file) {
				$message->save(); // Save the message
			} else {
				return redirect()->back()->withErrors(['message' => 'Please provide either a message or a file.']);
			}
		}


	}
