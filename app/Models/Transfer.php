<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    /** @use HasFactory<\Database\Factories\TransferFactory> */
    use HasFactory, SoftDeletes;

    protected $visible = ['value', 'user_payer_id', 'user_payee_id'];

    protected $fillable = [
        'value',
        'user_payer_id',
        'user_payee_id',
        'token',
    ];

    protected $casts = [
        'type' => UserType::class,
    ];
}
