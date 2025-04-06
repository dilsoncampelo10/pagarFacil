<?php

namespace Tests\Feature\App\Utils;

use App\Models\User;
use App\Utils\BalanceUtil;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BalanceUtilTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_sufficient_balance()
    {
        $user = User::factory()->create(['balance' => 500]);
        $this->actingAs($user);

        BalanceUtil::ensureSufficientBalance(300);

        $this->assertTrue(true);
    }

    public function test_throws_exception_if_balance_is_insufficient()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Insufficient balance.');

        $user = User::factory()->create(['balance' => 100]);
        $this->actingAs($user);

        BalanceUtil::ensureSufficientBalance(300);
    }
}
