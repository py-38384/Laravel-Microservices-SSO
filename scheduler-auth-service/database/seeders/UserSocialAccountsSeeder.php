<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserSocialAccount;

class UserSocialAccountsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        // Define your social platforms and their pages dynamically
        $socialPlatforms = [
            'Facebook' => [
                'Facebook Page One',
                'Facebook Page Two',
            ],
            'Instagram' => [
                'Instagram Page One',
                'Instagram Page Two',
            ],
            'Twitter' => [
                'Twitter Page One',
                'Twitter Page Two',
            ],
        ];

        foreach ($users as $user) {
            foreach ($socialPlatforms as $platform => $pages) {
                UserSocialAccount::create([
                    'user_id' => $user->id,
                    'title' => $platform,
                    'pages' => $pages, // pass array directly, Eloquent will handle JSON
                ]);
            }
        }
    }
}
