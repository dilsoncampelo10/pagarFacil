<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_user_wallet_data()
    {
        $user = User::factory()->create([
            'full_name' => 'João Silva',
            'type' => UserType::COMMON->name,
            'balance' => 1000,
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/wallet');

        $response->assertStatus(200)
            ->assertJson([
                'full_name' => 'João Silva',
                'type' => UserType::COMMON->name,
                'balance' => 1000,
            ]);
    }
}
