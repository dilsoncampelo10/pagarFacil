<?php

namespace Tests\Feature\App\Utils;

use App\Utils\TransactionGatewayUtil;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TransactionGatewayUtilTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorization_success()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'success',
                'data' => ['authorization' => true]
            ], 200)
        ]);

        $this->expectNotToPerformAssertions();

        TransactionGatewayUtil::authorize();
    }

    public function test_authorization_fails()
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response([
                'status' => 'fail',
                'data' => ['authorization' => false]
            ], 200)
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Authorization failed.');

        TransactionGatewayUtil::authorize();
    }

    public function test_notify_sends_post_request()
    {
        Http::fake();

        TransactionGatewayUtil::notify();

        Http::assertSent(function ($request) {
            return $request->url() === 'https://util.devi.tools/api/v1/notify'
                && $request->method() === 'POST';
        });
    }
}
