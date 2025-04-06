<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transfer>
 */
class TransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'value' => fake()->randomFloat(2, 10, 1000),
            'user_payer_id' => \App\Models\User::factory(),
            'user_payee_id' => \App\Models\User::factory(),
            'token'  => Str::uuid()
        ];
    }
}
