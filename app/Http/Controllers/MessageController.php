<?php

	namespace App\Http\Controllers;

	use App\Models\Message;
	use App\Models\User;
	use Illuminate\Http\Request;

	class MessageController extends Controller
	{

		public function index()
		{
			// Fetch all unique chat users for the authenticated user
			$userId = auth()->id();

			$chats = Message::where('sender_id', $userId)
				->orWhere('receiver_id', $userId)
				->with(['sender', 'receiver'])
				->get()
				->groupBy(function ($message) use ($userId) {
					// Group messages by the user ID of the other person
					return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
				});

			return view('messages.index', compact('chats'));
		}


		public function show(User $user)
		{
			$messages = Message::where(function ($query) use ($user) {
				$query->where('sender_id', auth()->id())
					->orWhere('receiver_id', auth()->id());
			})->where(function ($query) use ($user) {
				$query->where('sender_id', $user->id)
					->orWhere('receiver_id', $user->id);
			})
				->orderBy('created_at', 'asc')
				->get();
			$freelancer = User::where('usertype', 'freelancer');


			return view('messages.chat', compact('messages', 'user', 'freelancer'));
		}

		public function store(Request $request)
		{
			$request->validate([
				'message' => 'required|string|max:1000',
				'receiver_id' => 'required|exists:users,id', // Make sure this is passed in the request
			]);

			Message::create([
				'sender_id' => auth()->id(), // The ID of the currently authenticated user
				'receiver_id' => $request->get('receiver_id'), // Use freelancer's ID as receiver_id
				'message' => $request->get('message'),
				'status' => 'unread',
			]);

			return redirect()->route('chat.show', $request->get('receiver_id'));
		}


		public function markAsRead($receiver_id)
		{
			Message::where('sender_id', $receiver_id)
				->where('receiver_id', auth()->id())
				->update(['status' => 'read']);
		}
	}
