<?php

namespace Tests\Feature\App\Services;

use App\Models\Transfer;
use App\Models\User;
use App\Services\TransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransferServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_transfer_successful()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response(['status' => 'success', 'data' => ['authorization' => true]], 200),
            'https://util.devi.tools/api/v1/notify' => Http::response([], 200),
        ]);

        $payer = User::factory()->create(['balance' => 1000]);
        $payee = User::factory()->create(['balance' => 200]);

        $this->actingAs($payer);

        $service = new TransferService();

        $transfer = $service->transfer([
            'user_payee_id' => $payee->id,
            'value' => 300
        ]);

        $this->assertInstanceOf(Transfer::class, $transfer);
        $this->assertDatabaseHas('transfers', [
            'user_payer_id' => $payer->id,
            'user_payee_id' => $payee->id,
            'value' => 300,
        ]);

        $this->assertEquals(700, $payer->fresh()->balance);
        $this->assertEquals(500, $payee->fresh()->balance);
    }

    public function test_transfer_to_self_throws_exception()
    {
        $user = User::factory()->create(['balance' => 1000]);

        $this->actingAs($user);

        $service = new TransferService();

        $result = $service->transfer([
            'user_payee_id' => $user->id,
            'value' => 100
        ]);

        $this->assertEquals("You can't transfer to yourself.", $result);
    }
}
