<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginController extends Controller
    {
        public function index()
        {
            return view('auth.login');
        }

        public function login(Request $request)
        {
            // Validate the incoming request data
            $attributes = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Attempt to authenticate the user
            if (Auth::attempt($attributes)) {
                // Regenerate the session to prevent session fixation attacks
                $request->session()->regenerate();

                // Redirect the user to their intended URL or to the default route based on their usertype
                return redirect()->intended(Auth::user()->usertype === 'client' ? '/my' : '/my');
            }
            // If authentication fails, redirect back with an error message
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }


        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/');
        }
    }
