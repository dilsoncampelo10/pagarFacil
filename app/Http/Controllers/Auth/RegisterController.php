<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUser;
use App\Models\User;

class RegisterController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"full_name", "cpf/cnpj", "email", "password", "password_confirmation"},
     *             @OA\Property(property="full_name", type="string", example="Dilson Campelo"),
     *             @OA\Property(property="cpf/cnpj", type="string", example="123.456.789-00"),
     *             @OA\Property(property="email", type="string", format="email", example="dilson@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="12345678"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="full_name", type="string", example="Dilson Campelo"),
     *             @OA\Property(property="cpf/cnpj", type="string", example="123.456.789-00"),
     *             @OA\Property(property="email", type="string", example="dilson@example.com"),
     *             @OA\Property(property="type", type="string", example="COMMON"),
     *             @OA\Property(property="balance", type="number", example=0),
     *             @OA\Property(property="created_at", type="string", example="2025-04-06T16:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", example="2025-04-06T16:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     type="array",
     *                     @OA\Items(type="string", example="The email has already been taken.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(CreateUser $request)
    {
        $data = $request->all();

        $data['type'] =  strlen($data['cpf/cnpj']) <= 14 ? UserType::COMMON->name : UserType::SHOPKEEPER->name;

        $user = User::create($data);

        return response()->json($user, 201);
    }
}
