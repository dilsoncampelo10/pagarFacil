<?php

namespace Tests\Feature\App\Http\Request;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CreateTransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_requires_value_and_user_payee_id()
    {
        $user = User::factory()->create(['type' => UserType::COMMON->name]);
        $this->actingAs($user);

        $response = $this->postJson('/api/transfer', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['value', 'user_payee_id']);
    }

    public function test_it_accepts_valid_request_transfer()
    {
        $payer = User::factory()->create([
            'type' => UserType::COMMON->name,
            'balance' => 100
        ]);

        $payee = User::factory()->create();

        $this->actingAs($payer);

        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'success',
                'data' => ['authorization' => true]
            ], 200),

            'https://util.devi.tools/api/v1/notify' => Http::response([], 200),
        ]);

        $validData = [
            'value' => 5,
            'user_payee_id' => $payee->id,
        ];

        $response = $this->postJson('/api/transfer', $validData);

        $response->assertStatus(201);
    }


    public function test_it_denies_request_from_shopkeeper()
    {
        $user = User::factory()->create(['type' => UserType::SHOPKEEPER->name]);
        $this->actingAs($user);

        $data = [
            'value' => 100,
            'user_payee_id' => 2,
        ];

        $response = $this->postJson('/api/transfer', $data);

        $response->assertStatus(403);
    }
}
