<?php

namespace App\Services;

use App\Models\Transfer;
use App\Models\User;
use App\Utils\BalanceUtil;
use App\Utils\TransactionGatewayUtil;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TransferService
{
    public function transfer(array $data)
    {
        try {
            $this->validateSelfTransfer($data['user_payee_id']);

            BalanceUtil::ensureSufficientBalance($data['value']);
            
            TransactionGatewayUtil::authorize();

            DB::beginTransaction();

            $transfer = $this->createTransfer($data);

            BalanceUtil::transferBalance($data['value'], $data['user_payee_id']);

            TransactionGatewayUtil::notify();

            DB::commit();

            return $transfer;
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    private function validateSelfTransfer($payeeId): void
    {
        if (Auth::id() === $payeeId) {
            throw new Exception("You can't transfer to yourself.");
        }
    }

    private function createTransfer(array $data): Transfer
    {
        return Transfer::create([
            'value' => $data['value'],
            'user_payer_id' => Auth::id(),
            'user_payee_id' => $data['user_payee_id'],
            'token' => Str::uuid()
        ]);
    }
}