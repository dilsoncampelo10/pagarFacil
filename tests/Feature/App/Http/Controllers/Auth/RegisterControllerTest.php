<?php

namespace Tests\Feature\App\Http\Controllers\Auth;

use App\Enums\UserType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user_with_cpf_becomes_common()
    {
        $data = [
            'full_name' => 'Dilson',
            'email' => 'dilson@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cpf/cnpj' => '123.456.789-00',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'dilson@example.com',
            'type' => UserType::COMMON->name,
        ]);
    }

    public function test_register_user_with_cnpj_becomes_shopkeeper()
    {
        $data = [
            'full_name' => 'Loja DC',
            'email' => 'lojadc@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'cpf/cnpj' => '12.345.678/0001-00',
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'lojadc@example.com',
            'type' => UserType::SHOPKEEPER->name,
        ]);
    }
}
