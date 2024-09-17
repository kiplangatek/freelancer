<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;

	class OtpMail extends Mailable
	{
		use Queueable, SerializesModels;

		public $user;

		/**
		 * Create a new message instance.
		 *
		 * @param \App\Models\User $user
		 */
		public function __construct($user)
		{
			$this->user = $user;
		}

		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			return $this->view('emails.otp')
				->subject('Your OTP Code for Registration')
				->with(['otp' => $this->user->otp]);
		}
	}
