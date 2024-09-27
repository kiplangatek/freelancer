<?php

	namespace App\Http\Controllers\Auth;

	use App\Http\Controllers\Controller;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

	class AuthenticatedSessionController extends Controller
	{
		/**
		 * Handle an incoming authentication request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @return \Illuminate\Http\RedirectResponse
		 */
		public function login(Request $request)
		{
			$credentials = $request->only('email', 'password');

			// Attempt to authenticate the user
			if (Auth::attempt($credentials)) {
				$user = Auth::user();

				// Check if the user is suspended
				if ($user->suspended) {
					Auth::logout();

					return redirect()->route('login')->withErrors([
						'email' => 'Your account is suspended.',
					]);
				}

				if ($user->otp !== null) {  // Assuming the OTP field is not null if not verified
					Auth::logout();

					return redirect()->route('otp.verify')->withErrors([
						'email' => 'You need to verify your OTP before logging in.',
					])->with('email', $user->email);
				}

				$request->session()->regenerate();

				return redirect()->intended('/my');
			}

			return back()->withErrors([
				'email' => 'Wrong email or password.',
			]);
		}

	}
