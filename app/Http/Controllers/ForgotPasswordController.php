<?php

	namespace App\Http\Controllers;

	use App\Mail\PasswordReset;
	use App\Mail\ResetPasswordMail;
	use App\Models\Password;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Support\Str;
	use Illuminate\Support\Facades\Log;
	use Illuminate\Support\Facades\DB;

	class ForgotPasswordController extends Controller
	{
		public function showLinkRequestForm()
		{
			return view('auth.passwords.email'); // View for requesting password reset
		}

		public function sendResetLink(Request $request)
		{
			$request->validate([
				'email' => 'required|email|exists:users,email',
			]);

			$token = Str::random(60);

			// Update or create the token record
			DB::table('password_resets')->updateOrInsert(
				['email' => $request->email],
				['token' => $token, 'created_at' => now()]
			);

			// Send the email with the token
			Mail::to($request->email)->send(new ResetPasswordMail($token)); 

			return back()->with('status', 'Password reset link sent! Check your email.');
		}


		public function showResetForm($token)
		{
			return view('auth.passwords.reset', ['token' => $token]);
		}


		public function reset(Request $request)
		{
			$request->validate([
				'email' => 'required|email|exists:users,email',
				'password' => 'required|string|min:8|confirmed',
				'token' => 'required'
			]);

			$passwordReset = Password::where('email', $request->email)
				->where('token', $request->token)
				->first();

			if (!$passwordReset) {
				return back()->withErrors(['email' => 'Invalid token or email.']);
			}

			// Reset the user's password
			$user = User::where('email', $request->email)->first();
			$user->update(['password' => bcrypt($request->password)]);

			// Delete the token after reset
			Password::where('email', $request->email)
				->where('token', $request->token)
				->delete();

			Mail::to($user->email)->send(new PasswordReset($user));
			return redirect('/login')->with('status', 'Password reset successfully!');
		}

	}

