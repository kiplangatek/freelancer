<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Mail\Mailables\Envelope;
	use Illuminate\Queue\SerializesModels;

	class ResetPasswordMail extends Mailable
	{
		use Queueable, SerializesModels;

		public $token;

		public function envelope()
		{
			return new Envelope(
				subject: 'Password Reset Request',
			);
		}

		public function __construct($token)
		{
			$this->token = $token;
		}

		public function build()
		{
			return $this->view('emails.reset')->with('token', $this->token);
		}
	}
