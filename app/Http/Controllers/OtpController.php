<?php

	namespace App\Http\Controllers;

	use App\Mail\OtpMail;
	use App\Mail\RegistrationConfirmation;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Mail;

	class OtpController extends Controller
	{
		public function showForm()
		{
			return view('auth.otp'); // Ensure this view exists
		}

		public function verifyOtp(Request $request)
		{
			// Validate the incoming request data
			$request->validate([
				'otp' => ['required', 'digits:6'],
				'email' => ['required', 'email'],
			]);

			// Retrieve the user based on email
			$user = User::where('email', $request->input('email'))->first();

			if ($user) {

				// Check if the OTP is correct and not expired
				if ($user->otp === $request->input('otp') && now()->lt($user->otp_expires_at)) {
					// Clear OTP after successful verification
					$user->otp = null;
					$user->email_verified_at = now();
					$user->otp_expires_at = null;
					$user->save();

					// Log the user in
					Auth::login($user);

					Mail::to($user->email)->send(mailable: new RegistrationConfirmation($user));

					return redirect()->intended('/');
				}
			}

			// If the OTP is invalid or expired, return an error
			return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
		}

		public function resendOtp(Request $request)
		{
			$request->validate([
				'email' => ['required', 'email', 'exists:users,email'],
			]);

			$user = User::where('email', $request->input('email'))->first();

			if ($user) {
				// Check if the previous OTP is still valid
				if ($user->otp_expires_at && $user->otp_expires_at->isFuture()) {
					return back()->withErrors(['email' => 'An OTP was already sent. Please wait until it expires before requesting a new one.']);
				}

				$user->otp = rand(100000, 999999);           // Generate a 6-digit OTP
				$user->otp_expires_at = now()->addMinutes(5);// OTP valid for 5 minutes
				$user->save();

				// Send the new OTP via email
				try {
					Mail::to($user->email)->send(new OtpMail($user));
					return back()->with('message', 'A new OTP has been sent to your email.');
				}
				catch (\Exception $e) {
					return back()->withErrors(['email' => 'Unable to resend OTP. Please try again.']);
				}
			}

			return back()->withErrors(['email' => 'The provided email does not exist.']);
		}

	}
