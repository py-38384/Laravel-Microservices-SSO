<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserInterestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_interests_with_dynamic_data()
    {
        // Create and authenticate user
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Dynamic interest data
        $interestData = [
            'interest_type' => collect(['Doing the work', 'Learning', 'Networking'])->random(),
            'interests' => [
                'Interest ' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5),
                'Interest ' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5),
                'Interest ' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 5),
            ]
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/users/info/interests', $interestData);

        // Assertions
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User info updated successfully.',
                 ]);

        // Optional: check database or user model updated if stored as JSON
        $this->assertEquals($interestData['interest_type'], $user->fresh()->interest_type);
    }
}
