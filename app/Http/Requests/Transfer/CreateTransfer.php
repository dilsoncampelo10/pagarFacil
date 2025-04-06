<?php

namespace App\Http\Requests\Transfer;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateTransfer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && $user->type !== UserType::SHOPKEEPER->name;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => 'required|numeric',
            'user_payee_id' => 'required',
        
        ];
    }
}
