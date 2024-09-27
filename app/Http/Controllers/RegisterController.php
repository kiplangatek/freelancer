<?php

	namespace App\Http\Controllers;

	use App\Mail\OtpMail;
	use App\Models\User;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Illuminate\Support\Facades\Mail;
	use Illuminate\Validation\Rules\Password;
	use Random\RandomException;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Validation\Rule;
	use Illuminate\Support\Facades\DB;


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
						// Check if the username exists in a case-insensitive way, excluding the current user
						$exists = DB::table('users')
							->whereRaw('LOWER(username) = ?', [strtolower($value)])
							->exists();
						if ($exists) {
							$fail('The ' . $attribute . ' has already been taken.');
						}
					},
				],
				'email' => ['required', 'email', 'max:254', 'unique:users,email'],
				'usertype' => ['required'],
				'photo' => ['required', 'mimes:png,jpg,webp,jpeg'],
				'password' => ['required', Password::min(8), 'confirmed'],
			]);

			$details = $request->all();

			if ($image = $request->file('photo')) {
				$destinationPath = 'storage/avatars/';
				$profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
				$image->move($destinationPath, $profileImage);
				$details['photo'] = $profileImage;
			} else {
				$details['photo'] = 'default.png';
			}

			// Generate OTP and set expiration time
			$otp = rand(100000, 999999);
			$details['otp'] = $otp;
			$details['otp_expires_at'] = now()->addMinutes(10);

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
			// Get the authenticated user's ID
			$userId = Auth::id();

			// Validate the incoming request data
			$request->validate([
				'name' => ['nullable'],
				'username' => ['required',
					'string',
					'max:255',
					'regex:/^[a-zA-Z0-9]+$/',
					function ($attribute, $value, $fail) use ($userId) {
						// Check if the username exists in a case-insensitive way, excluding the current user
						$exists = DB::table('users')
							->whereRaw('LOWER(username) = ?', [strtolower($value)])
							->where('id', '!=', $userId)
							->exists();

						if ($exists) {
							$fail('The ' . $attribute . ' has already been taken.');
						}
					},
				],
				'email' => ['nullable', 'email', 'max:254', 'unique:users,email,' . $userId],
				'photo' => ['nullable', 'mimes:png,jpg,webp,jpeg'],
			]);

			// Find the user by ID
			$user = User::findOrFail($userId);

			// Handle photo upload if a new one is provided
			if ($request->hasFile('photo')) {
				$image = $request->file('photo');
				$destinationPath = 'storage/avatars/';
				$profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

				// Check and delete the old image if it's not 'default.png'
				if ($user->photo && $user->photo !== 'default.png') {
					$oldImagePath = public_path($destinationPath . $user->photo);
					if (file_exists($oldImagePath)) {
						unlink($oldImagePath);
					}
				}

				// Move the new image to the destination path
				$image->move($destinationPath, $profileImage);
				$data['photo'] = $profileImage;
			} else {
				// Keep the existing photo if not updated
				$data['photo'] = $user->photo;
			}

			// Only update the fields that are present in the request
			$user->update(array_filter($request->only(['name', 'username', 'email', 'photo']), function ($value) {
				return !is_null($value) && $value !== '';
			}));

			// Redirect or return a response
			return redirect()->route('profile')->with('success', 'Profile updated successfully.');
		}


	}
