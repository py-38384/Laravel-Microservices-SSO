<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_auto_generated_data()
    {

        $userData = User::factory()->make()->toArray();

        $userData['password'] = 'Password123!';
        $userData['password_confirmation'] = 'Password123!';


        $response = $this->postJson('/api/v1/users/register', $userData);


        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User created successfully',
                'data' => 'Email varification Code sent to ' . $userData['email']
            ]);


        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'first_name' => $userData['first_name']
        ]);
    }
}
