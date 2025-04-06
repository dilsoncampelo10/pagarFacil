<?php

namespace Database\Factories;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cpfOrCnpj = $this->faker->randomElement(['cpf', 'cnpj']);

        $document = $cpfOrCnpj === 'cpf'
            ? $this->generateFormattedCPF()
            : $this->generateFormattedCNPJ();

        return [
            'full_name' => fake()->name(),
            'cpf/cnpj' => $document,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'type' => $cpfOrCnpj === 'cpf' ? UserType::COMMON->name : UserType::SHOPKEEPER->name,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    private function generateFormattedCPF(): string
    {
        return $this->faker->numerify('###.###.###-##');
    }

    private function generateFormattedCNPJ(): string
    {
        return $this->faker->numerify('##.###.###/####-##');
    }
}
