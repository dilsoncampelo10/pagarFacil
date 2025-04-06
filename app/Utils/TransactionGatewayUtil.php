<?php

namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Http;

class TransactionGatewayUtil
{
    public static function authorize(): void
    {
        $response = Http::get('https://util.devi.tools/api/v2/authorize')->json();

        if (!($response['status'] === 'success' && $response['data']['authorization'] === true)) {
            throw new Exception('Authorization failed.');
        }
    }

    public static function notify(): void
    {
        Http::post('https://util.devi.tools/api/v1/notify');
    }
}
