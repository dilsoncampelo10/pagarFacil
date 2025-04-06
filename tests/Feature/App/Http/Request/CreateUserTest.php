<?php

namespace Tests\Feature\App\Http\Request;

use App\Http\Requests\User\CreateUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_passes_with_valid_data()
    {
        $request = new CreateUser();

        $data = [
            'full_name' => 'Maria Souza',
            'cpf/cnpj' => '123.456.789-01',
            'email' => 'maria@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertTrue($validator->passes());
    }

   
    public function test_it_fails_with_invalid_data()
    {
        $request = new CreateUser();

        $data = [
            'full_name' => 'Jo', 
            'cpf/cnpj' => '123', 
            'email' => 'email_invalido', 
            'password' => 'secret', 
         
        ];

        $validator = Validator::make($data, $request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('full_name', $validator->errors()->toArray());
        $this->assertArrayHasKey('cpf/cnpj', $validator->errors()->toArray());
        $this->assertArrayHasKey('email', $validator->errors()->toArray());
        $this->assertArrayHasKey('password', $validator->errors()->toArray());
    }
}
