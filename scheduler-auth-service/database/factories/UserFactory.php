<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password123'), // default password
            'email_verified_at' => now(),
            'pricing_plan_id' => $this->faker->randomElement([null, 'basic', 'premium']),
            'organization' => $this->faker->company(),
            'organization_size' => $this->faker->randomElement(['1-10', '11-50', '51-200']),
            'is_agency' => $this->faker->boolean(30),
            'country' => $this->faker->country(),
            'time_zone' => $this->faker->timezone(),
            'interest_type' => $this->faker->word(),
            'interests' => $this->faker->words(3),
        ];
    }
}
