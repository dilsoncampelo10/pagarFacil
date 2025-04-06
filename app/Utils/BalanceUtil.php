<?php

namespace App\Utils;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class BalanceUtil
{
    public static function ensureSufficientBalance(float $amount): void
    {
        if (Auth::user()->balance < $amount) {
            throw new Exception('Insufficient balance.');
        }
    }

    public static function transferBalance(float $amount, int $payeeId): void
    {
        $payer = Auth::user();
        $payer->decrement('balance', $amount);

        $payee = User::findOrFail($payeeId);
        $payee->increment('balance', $amount);
    }
}
