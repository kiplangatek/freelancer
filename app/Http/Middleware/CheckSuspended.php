<?php

	namespace App\Http\Middleware;

	use Closure;
	use Illuminate\Support\Facades\Auth;

	class CheckSuspended
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure $next
		 * @return mixed
		 */
		public function handle($request, Closure $next)
		{
			if (Auth::check() && Auth::user()->suspended) {
				Auth::logout();

				return redirect()->route('login')->withErrors([
					'email' => 'Your account has been suspended.',
				]);
			}

			return $next($request);
		}
	}
