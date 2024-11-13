<?php

	namespace App\Http\Controllers;

	use App\Models\Message;
	use App\Events\MessageEvent;
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

		public function fetchMessages(Request $request)
		{
			$userId = Auth::user()->id;

			// Retrieve messages where the user is either the sender or the receiver
			$messages = Message::where(function ($query) use ($userId, $user) {
				$query->where('sender_id', $userId)->where('receiver_id', $user->id);
			})
				->orWhere(function ($query) use ($userId, $user) {
					$query->where('sender_id', $user->id)->where('receiver_id', $userId);
				})
				->orderBy('created_at', 'asc')  // Order by ascending to show older messages first
				->get();
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
			$request->validate([
				'message' => 'required|string',
				'receiver_id' => 'required|exists:users,id',
				'file' => 'nullable|file|mimes:jpeg,jpg,png,gif,pdf,doc,docx,rar|max:2048',
			]);

			// Store message logic
			$message = new Message();
			$message->message = $request->input('message');
			$message->receiver_id = $request->input('receiver_id');
			// Handle file upload
			if ($request->hasFile('file')) {
				$message->file = $request->file('file')->store('messages');
			}
			$message->sender_id = auth()->id();
			$message->save();

			return response()->json(['success' => true, 'message' => $message]);
		}


	}
