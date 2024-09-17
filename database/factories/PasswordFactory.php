<?php

	namespace Database\Factories;

	use Illuminate\Database\Eloquent\Factories\Factory;
	use Illuminate\Support\Str;

	/**
	 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Password>
	 */
	class PasswordFactory extends Factory
	{
		/**
		 * Define the model's default state.
		 *
		 * @return array<string, mixed>
		 */
		public function definition(): array
		{
			return [
				'email' => $this->faker->safeEmail,
				'token' => Str::random(60),
				'created_at' => now(),
			];
		}
	}
