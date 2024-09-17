<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Mail\Mailables\Content;
	use Illuminate\Mail\Mailables\Envelope;
	use Illuminate\Queue\SerializesModels;

	class CreateService extends Mailable
	{
		use Queueable, SerializesModels;

		public $freelancer;

		/**
		 * Create a new message instance.
		 *
		 * @param \App\Models\User $freelancer
		 */
		public function __construct($freelancer)
		{
			$this->freelancer = $freelancer;
		}

		/**
		 * Get the message envelope.
		 */
		public function envelope(): Envelope
		{
			return new Envelope(
				subject: 'Create Your First Service',
			);
		}

		/**
		 * Get the message content definition.
		 */
		public function content(): Content
		{
			return new Content(
				view: 'emails.create',
				with: ['freelancer' => $this->freelancer],
			);
		}

		/**
		 * Get the attachments for the message.
		 *
		 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
		 */
		public function attachments(): array
		{
			return [];
		}
	}
