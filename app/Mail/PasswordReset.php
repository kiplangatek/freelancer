<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Mail\Mailables\Envelope;
	use Illuminate\Queue\SerializesModels;

	class PasswordReset extends Mailable
	{
		use Queueable, SerializesModels;

		public $user; // Add any data you need to pass to the view

		/**
		 * Create a new message instance.
		 */
		public function __construct($user)
		{
			$this->user = $user; // Initialize with user or any data you need
		}

		/**
		 * Get the message envelope.
		 */
		public function envelope()
		{
			return new Envelope(
				subject: 'Your Password Was Reset',
			);
		}

		/**
		 * Get the message content definition.
		 */
		public function build()
		{
			return $this->view('emails.password-alert')
				->with([
					'user' => $this->user, // Pass data to the view if needed
				]);
		}

		/**
		 * Get the attachments for the message.
		 *
		 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
		 */
		public function attachments()
		{
			return [];
		}
	}
