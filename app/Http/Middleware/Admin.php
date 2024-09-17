<?php

	namespace App\Http\Middleware;

	use Closure;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;

	class Admin
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param \Illuminate\Http\Request $request
		 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
		 * @return mixed
		 */
		public function handle(Request $request, Closure $next)
		{
			if (Auth::check() && Auth::user()->usertype === 'admin') {
				// Allow the request to proceed if the user is an admin
				return $next($request);
			}

			// Redirect non-admin users to a different page, such as the home page
			return redirect('/')->with('error', 'You do not have access to this page.');
		}
	}
