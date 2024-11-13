<?php

	namespace App\Events;

	use App\Models\Message;
	use Illuminate\Broadcasting\Channel;
	use Illuminate\Broadcasting\InteractsWithSockets;
	use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
	use Illuminate\Foundation\Events\Dispatchable;
	use Illuminate\Queue\SerializesModels;

	class MessageEvent implements ShouldBroadcastNow
	{
		use Dispatchable, InteractsWithSockets, SerializesModels;

		public $message;  // Holds the message instance to be broadcasted
		public $sender_id; // Sender ID
		public $receiver_id; // Receiver ID

		/**
		 * Create a new event instance.
		 */
		public function __construct(Message $message)
		{
			$this->message = $message;
			$this->sender_id = $message->sender_id;
			$this->receiver_id = $message->receiver_id;
		}

		/**
		 * Get the channels the event should broadcast on.
		 *
		 * @return array<int, \Illuminate\Broadcasting\Channel>
		 */
		public function broadcastOn(): array
		{
			// Broadcast to a private channel based on the receiver ID
			return [
				new Channel('message.' . $this->receiver_id),
			];
		}
	}
