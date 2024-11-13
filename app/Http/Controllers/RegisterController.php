<?php

	namespace App\Http\Controllers;

	use App\Mail\OtpMail;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Validation\Rules\Password;
	use Random\RandomException;
	use Illuminate\Support\Facades\DB;
	use Illuminate\Support\Str;


	class RegisterController extends Controller
	{

		public function index()
		{

			return view('auth.register');
		}

		/**
		 * @throws RandomException
		 */
		public function register(Request $request)
		{
			$request->validate([
				'name' => ['required'],
				'username' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9]+$/',
					function ($attribute, $value, $fail) {
						$exists = DB::table('users')
							->whereRaw('LOWER(username) = ?', [strtolower($value)])
							->exists();
						if ($exists) {
							$fail("The $attribute has already been taken.");
						}
					},
				],
				'email' => ['required', 'email', 'max:254', 'unique:users,email'],
				'usertype' => ['required'],
				'photo' => ['nullable', 'mimes:png,jpg,webp,jpeg'],
				'password' => ['required', Password::min(8), 'confirmed'],
			]);

			$details = $request->all();

			// Handle photo upload
			if ($image = $request->file('photo')) {
				$destinationPath = 'storage/avatars/';

				// Use Str::random to generate a random string of letters only
				$randomLetters = Str::random(8); // You can specify length here (min 5, max 7)
				$profileImage = $randomLetters . "." . $image->getClientOriginalExtension();

				// Move the new image to the destination path
				$image->move($destinationPath, $profileImage);
				$details['photo'] = $profileImage;
			} else {
				$details['photo'] = 'default.png';
			}

			// Generate OTP and set expiration time
			$otp = rand(100000, 999999);
			$details['otp'] = $otp;
			$details['otp_expires_at'] = now()->addMinutes(10);

			// Create the user
			$user = User::create($details);

			// Send OTP via email
			Mail::to($user->email)->send(new OtpMail($user));

			return redirect()->route('otp.form')->with('email', $user->email);
		}

		public function profile()
		{
			$user = Auth::user();

			return view('profile.profile', compact('user'));
		}

		public function update(Request $request)
		{
			$userId = Auth::id();

			$request->validate([
				'name' => ['nullable'],
				'username' => [
					'required',
					'string',
					'max:255',
					'regex:/^[a-zA-Z0-9]+$/', // This allows only alphanumeric characters
					function ($attribute, $value, $fail) use ($userId) {
						$exists = DB::table('users')
							->whereRaw('LOWER(username) = ?', [strtolower($value)])
							->where('id', '!=', $userId)
							->exists();

						if ($exists) {
							$fail("The $attribute has already been taken.");
						}
					},
				],
				'email' => ['nullable', 'email', 'max:254', 'unique:users,email,' . $userId],
				'photo' => ['nullable', 'mimes:png,jpg,webp,jpeg'],
			]);

			$user = User::findOrFail($userId);
			$data = $request->only(['name', 'username', 'email']);

			// Handle photo upload
			if ($request->hasFile('photo')) {
				$image = $request->file('photo');
				$destinationPath = 'storage/avatars/';

				// Use Str::random to generate a random string of letters only
				$randomLetters = Str::random(8); // Random string of letters with max length of 7
				$profileImage = $randomLetters . "." . $image->getClientOriginalExtension();

				// Check and delete the old image if it's not 'default.png'
				if ($user->photo && $user->photo !== 'default.png') {
					$oldImagePath = public_path("{$destinationPath}{$user->photo}");
					if (file_exists($oldImagePath)) {
						unlink($oldImagePath);
					}
				}

				// Move the new image to the destination path
				$image->move($destinationPath, $profileImage);
				$data['photo'] = $profileImage;
			} else {
				$data['photo'] = $user->photo;
			}

			$user->update($data);

			return redirect()->route('profile')->with('success', 'Profile updated successfully.');
		}


	}
