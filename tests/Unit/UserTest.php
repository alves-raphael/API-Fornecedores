<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Validation\ValidationException;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testUserRegister()
    {
        $response = $this->post("/api/user", [
            "name" => "nobody",
            'password' => 'secret',
            "email" => "nobody@email.com",
            "address" => "Rua São Tomé",
            "cep" => "03676011",
            "phone" => "11948384051",
            "cnpj" => "15.803.436/0001-96",
        ]);

        $response->assertStatus(201)->assertJson(['status' => 'Created']);
        $this->assertEquals(1, count(User::all()));
    }

    public function testEmailAndNoPasswordValidation(){
        $response = $this->post("/api/user", [
            "name" => "nobody",
            "email" => "nasdasd",
            "address" => "Rua São Tomé",
            "cep" => "03676011",
            "phone" => "11948384051",
            "cnpj" => "15.803.436/0001-96",
        ]);

        $response->assertSessionHasErrors(['password', 'email']);
        $response->assertStatus(302);
    }

    public function testCNPJValidation(){
        $response = $this->post("/api/user", [
            "name" => "nobody",
            'password' => 'secret',
            "email" => "nobody@email",
            "address" => "Rua São Tomé",
            "cep" => "2",
            "phone" => "11948384051",
            "cnpj" => "15",
        ]);

        $response->assertSessionHasErrors(['cnpj', 'cep']);
        $response->assertStatus(302);
    }
}
