<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        return response()->json([
            'full_name' => $user->full_name,
            'type' => $user->type,
            'balance' => $user->balance,
        ]);
    }
}
