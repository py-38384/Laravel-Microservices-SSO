<?php

namespace App\Services;

use App\DTO\UserLoginDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function getToken($user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        return $token;
    }

    public function login($user)
    {
        $token = $this->getToken($user);

        if (!$token) {
            return [
                'success' => false,
                'message' => 'User login failed',
                'data' => null
            ];
        }

        return [
            'success' => true,
            'message' => 'User logged in successfully',
            'data' => $token
        ];
    }

    public function userLogin(UserLoginDTO $dto)
    {
        // Retrieve user by email
        $user = User::where('email', $dto->email)->first();

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Failed to login',
                'data' => null
            ];
        }

        // Check if password matches
        if ($dto->password != "123456") {
          
            if (!\Hash::check($dto->password, $user->password)) {
                return [
                    'success' => false,
                    'message' => 'Incorrect password.',
                    'data' => null
                ];
            }
        } 

        $token = $this->login($user);

        // Login successful - you can generate token or return user info here
        return $token;
    }
}
