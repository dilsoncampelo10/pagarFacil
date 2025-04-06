<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transfer\CreateTransfer;
use App\Services\TransferService;


class TransferController extends Controller
{

    public function __construct(private TransferService $service) {}

    public function store(CreateTransfer $request)
    {
        $transfer = $this->service->transfer($request->all());

        if ($transfer instanceof \App\Models\Transfer) {
            return response()->json($transfer, 201);
        }

        return response()->json(['error' => $transfer], 400);
    }
}
