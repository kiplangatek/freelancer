<?php

    namespace Database\Factories;

    use App\Models\Service;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;

    class ServiceFactory extends Factory
    {
        protected $model = Service::class;

        public function definition(): array
        {
            return [
                'image' => $this->faker->imageUrl(),
                'freelancer_id' => User::factory(),
                'details' => $this->faker->paragraphs(3, true),
                'price' => $this->faker->randomFloat(2, 500, 90000),
            ];
        }

    }
