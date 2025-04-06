<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUser;
use App\Models\User;

class RegisterController extends Controller
{
    public function store(CreateUser $request)
    {
        $data = $request->all();

        $data['type'] =  strlen($data['cpf/cnpj']) <= 14 ? UserType::COMMON->name : UserType::SHOPKEEPER->name;

        $user = User::create($data);

        return response()->json($user, 201);
    }
}
