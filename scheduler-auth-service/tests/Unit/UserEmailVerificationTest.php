<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserEmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_verify_email()
    {
        // Create a user
        $user = User::factory()->create([
            'email_verified_at' => null, // Ensure not verified
        ]);

        $verificationData = [
            'email' => $user->email,
            'code'  => '123456', // use the code your controller accepts
        ];

        $response = $this->postJson('/api/v1/users/verify', $verificationData);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User verified successfully',
                 ]);

        // Check email_verified_at is now set
        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
