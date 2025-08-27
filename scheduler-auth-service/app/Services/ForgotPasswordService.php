<?php

namespace App\Services;

use App\DTO\ForgotPasswordDTO;
use App\DTO\ResetPasswordDTO;
use App\Mail\ResetPasswordMail;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordService
{
    public function __construct(private UserRepository $userRepository) {}

    public function sendResetLink(ForgotPasswordDTO $dto)
    {
        $user = $this->userRepository->findByEmail($dto->email);
        if (!$user) {
            return ['message' => 'User not found'];
        }

        $token = Str::random(60);
        $this->userRepository->storePasswordResetToken($dto->email, $token);

        // Send Email

        Mail::to($user->email)->send(new ResetPasswordMail($token));

        return [
            'message' => 'Reset link sent'
        ];
    }

    public function resetPassword(ResetPasswordDTO $dto)
    {
        $record = $this->userRepository->getPasswordResetRecord($dto->email, $dto->token);

        if (!$record) {
            return ['message' => 'Invalid token or email'];
        }

        $user = $this->userRepository->findByEmail($dto->email);
        if (!$user) {
            return ['message' => 'User not found'];
        }

        $user->password = Hash::make($dto->password);
        $user->save();

        $this->userRepository->deletePasswordResetRecord($dto->email);

        return ['message' => 'Password reset successful'];
    }
}
