<?php

	namespace App\Policies;

	use App\Models\Service;
	use App\Models\User;

	class ServicePolicy
	{
		/**
		 * Create a new policy instance.
		 */

		public function apply(User $user, Service $service)
		{
			// You can't apply for your own service
			return $user->id !== $service->freelancer_id && $user->usertype != 'admin';
		}

		/**
		 * Determine if the user can edit the service.
		 */
		public function edit(User $user, Service $service)
		{
			// You can only edit your own service
			return $user->id === $service->freelancer_id;
		}

		public function __construct()
		{
			//
		}
	}
