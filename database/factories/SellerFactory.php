<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class SellerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), 
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
            'contact_email' => $this->faker->safeEmail,
        ];
    }
}