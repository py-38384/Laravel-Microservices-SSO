<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        
        $password = '123456';
        $user = User::factory()->create([
            'email' => 'sohag@blaxion.com',
            'password' => Hash::make($password)
        ]);

        $loginData = [
            'email' => 'sohag@blaxion.com',
            'password' => $password
        ];

        $response = $this->postJson('/api/v1/users/login', $loginData);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User logged in successfully'
            ]);

        $this->assertArrayHasKey('data', $response->json());
    }
}
