<?php

	namespace App\Mail;

	use Illuminate\Bus\Queueable;
	use Illuminate\Mail\Mailable;
	use Illuminate\Queue\SerializesModels;

	class AccountSuspended extends Mailable
	{
		use Queueable, SerializesModels;

		public $user;
		public $status;

		/**
		 * Create a new message instance.
		 *
		 * @param \App\Models\User $user
		 * @param string $status
		 * @return void
		 */
		public function __construct($user, $status)
		{
			$this->user = $user;
			$this->status = $status;
		}

		/**
		 * Build the message.
		 *
		 * @return $this
		 */
		public function build()
		{
			$subject = $this->status === 'suspended'
				? 'Your Account Has Been Suspended'
				: 'Your Account Has Been Restored';

			return $this->view('emails.suspension')
				->subject($subject) // Set the subject here
				->with([
					'name' => $this->user->name,
					'usertype' => $this->user->usertype,
					'status' => $this->status,
				]);
		}
	}
