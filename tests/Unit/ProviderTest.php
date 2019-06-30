<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Provider;

class ProviderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function createUser(){
        return User::create([
            "name"=> "raphael",
            "email"=> "nobody@email.com.br",
            'password' => 'secret',
            "address"=> "Rua São Tomé",
            "cep"=> "03676011",
            "phone"=> "11948384051",
            "cnpj"=> "15803436000196"
        ]);
    }

    public function testProviderRegister() {
        $user = $this->createUser();
        $response = $this->post('/api/provider', [
            "name" => "Super provider",
            "email" => "provider@email.com",
            "monthly_payment" => "500.00",
            'api_token' => $user->api_token
        ]);
        
        $response->assertStatus(201);
        $this->assertEquals(1, count(Provider::all()));
    }

    public function testProvidersQuery(){
        $user = $this->createUser();
        $provider = Provider::create( [
            "name" => "Super provider",
            "email" => "provider@email.com",
            "monthly_payment" => "500.00",
            'user_id' => $user->id
        ]);
        
        $provider1 = Provider::create( [
            "name" => "Ultra provider",
            "email" => "ultraprovider@email.com",
            "monthly_payment" => "812.00",
            'user_id' => $user->id
        ]);
  
        $response = $this->withHeaders(['Accept'=>'Application/json'])->get("api/providers?api_token=".$user->api_token);
        $response->assertStatus(200)->assertJson([
            [
                "id" => $provider->id,
                "name" => "Super provider",
                "email" => "provider@email.com",
                "monthly_payment" => "500.00",
                "user_id" => $provider->user_id,
                "created_at" => $provider->created_at->format('Y-m-d H:i:s'),
                "updated_at" => $provider->updated_at->format('Y-m-d H:i:s')
            ],
            [
                "id" => $provider1->id,
                "name" => "Ultra provider",
                "email" => "ultraprovider@email.com",
                "monthly_payment" => "812.00",
                "user_id" => $provider1->user_id,
                "created_at" => $provider1->created_at->format('Y-m-d H:i:s'),
                "updated_at" => $provider1->updated_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    public function testMissingValidation(){
        $user = $this->createUser();
        $response = $this->post('/api/provider', [
            'api_token' => $user->api_token
        ]);

        $response->assertSessionHasErrors(['email', 'name', 'monthly_payment']);
        $response->assertStatus(302);
    }

    public function testAuthentication(){
        $response = $this->withHeaders(['Accept'=>'application/json'])->post('/api/provider', [
            "name" => "Super provider",
            "email" => "provider@email.com",
            "monthly_payment" => "500.00"
        ]);

        $response->assertStatus(401)->assertJson(['message' => 'Unauthenticated.']);
    }

    public function testDelete(){
        $user = $this->createUser();
        $provider = Provider::create( [
            "name" => "Super provider",
            "email" => "provider@email.com",
            "monthly_payment" => "500.00",
            'user_id' => $user->id
        ]);

        $response = $this->delete("/api/provider?api_token={$user->api_token}&id={$provider->id}");
        $response->assertStatus(200)->assertJson(['status' => 'Deleted']);
        $this->assertEquals(null, Provider::find($provider->id));
    }

    public function testUpdate(){
        $user = $this->createUser();
        $provider = Provider::create( [
            "name" => "Super provider",
            "email" => "provider@email.com",
            "monthly_payment" => "500.00",
            'user_id' => $user->id
        ]);
        
        $response = $this->put("/api/provider?api_token={$user->api_token}&id={$provider->id}&name=Joseph");
        $response->assertStatus(200)->assertJson(['status' => 'Updated']);
        $provider = Provider::find($provider->id);
        $this->assertEquals($provider->name, 'Joseph');
    }
}
