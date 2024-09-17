<?php

	namespace App\Mail;

	use App\Models\Service;
	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;

	class NewApplication extends Mailable
	{
		use Queueable, SerializesModels;

		public Service $service;

		/**
		 * Create a new message instance.
		 *
		 * @param Service $service
		 * @return void
		 */
		public function __construct(Service $service)
		{
			$this->service = $service;
		}

		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this->subject('New Application for Your Service')
				->view('emails.application');
		}
	}
