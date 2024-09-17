<?php

	namespace App\Http\Middleware;

	use Closure;
	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\Auth;
	use Symfony\Component\HttpFoundation\Response;

	class FreelancerMiddleware
	{
		/**
		 * Handle an incoming request.
		 *
		 * @param Closure(Request): (Response) $next
		 */
		public function handle(Request $request, Closure $next)
		{
			if (Auth::check()) {
				if (Auth::user()->usertype !== 'freelancer') {
					return redirect('/client/dashboard');
				}
			}

			return $next($request);
		}

	}
