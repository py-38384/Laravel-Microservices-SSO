<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class SocialDocumentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_social_documents_with_dynamic_data()
    {
        // Create and authenticate a user
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        // Dynamic social accounts data
        $socialAccounts = collect(['facebook', 'instagram', 'linkedin'])
            ->map(function ($platform) {
                return [
                    'title' => ucfirst($platform),
                    'pages' => collect(range(1, rand(1, 3)))
                        ->map(fn ($page) => "page{$page} content " . substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 3))
                        ->toArray()
                ];
            })
            ->toArray();

        // Send request
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->postJson('/api/v1/users/info/social-accounts', $socialAccounts);

        // Assertions
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Social documents created successfully'
            ]);

        $this->assertArrayHasKey('data', $response->json());
    }
}
