<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\CreateTransfer;
use App\Services\TransferService;


class TransferController extends Controller
{

    public function __construct(private TransferService $service) {}
    /**
    *  @OA\Post(
    *      path="/api/transfer",
    *      summary="Create transfer",
    *      description="Creates a new transfer between users",
    *      tags={"Transfer"},
    *      security={{"bearerAuth":{}}},
    *      @OA\RequestBody(
    *          required=true,
    *          @OA\JsonContent(
    *              required={"value","user_payee_id"},
    *              @OA\Property(property="value", type="number", example=100),
    *              @OA\Property(property="user_payee_id", type="integer", example=2),
    *          )
    *      ),
    *      @OA\Response(
    *          response=201,
    *          description="Transfer created successfully",
    *          @OA\JsonContent(
    *              @OA\Property(property="value", type="number", example=100),
    *              @OA\Property(property="user_payer_id", type="integer", example=1),
    *              @OA\Property(property="user_payee_id", type="integer", example=2),
    *              @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-06T12:34:56Z"),
    *          )
    *      ),
    *      @OA\Response(
    *          response=400,
    *          description="Invalid data, insufficient balance, or authorization failed",
    *          @OA\JsonContent(
    *              @OA\Property(property="error", type="string", example="Insufficient balance / Authorization failed.")
    *          )
    *      )
    *  )
    */
    public function store(CreateTransfer $request)
    {
        $transfer = $this->service->transfer($request->all());

        if ($transfer instanceof \App\Models\Transfer) {
            return response()->json($transfer, 201);
        }

        return response()->json(['error' => $transfer], 400);
    }
}
