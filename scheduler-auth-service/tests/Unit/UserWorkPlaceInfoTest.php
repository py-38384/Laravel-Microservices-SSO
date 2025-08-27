<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserWorkPlaceInfoTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_work_place_info_with_dynamic_data()
    {
        // Create and authenticate user
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Dynamic workplace info
        $workPlaceData = [
            'organization' => 'Make Hub ' . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 4),
            'organization_size' => collect(['1-10', '11-50', '51-200'])->random(),
            'is_agency' => (bool) rand(0, 1),
            'country' => collect(['Bangladesh', 'USA', 'India'])->random(),
            'time_zone' => 'Dhaka (UTC +06:00)',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/users/info/work-place', $workPlaceData);

        // Assertions
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'User info updated successfully.'
                 ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'organization' => $workPlaceData['organization']
        ]);
    }
}
