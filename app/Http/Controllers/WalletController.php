<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


class WalletController extends Controller
{

    /**
     *  @OA\Get(
     *      path="/api/wallet",
     *      summary="Get wallet",
     *      description="Get balance in wallet user",
     *      tags={"Wallet"},
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Get wallet successfully",
     *            @OA\JsonContent(
     *              @OA\Property(property="full_name", type="string", example="Dilson Campelo"),
     *              @OA\Property(property="type", type="string", example="COMMON"),
     *              @OA\Property(property="balance", type="number", example=10)
     *          )
     *      )
     *  )
     */
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
