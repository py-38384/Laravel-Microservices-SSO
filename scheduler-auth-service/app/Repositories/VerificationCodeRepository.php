<?php

namespace App\Repositories;

use App\Models\VerificationCode;
use App\DTO\VerificationCodeDTO;

class VerificationCodeRepository
{
    public function updateOrCreateByEmail(VerificationCodeDTO $dto)
    {
        return VerificationCode::updateOrCreate(
            ['email' => $dto->email],
            $dto->toArray()
        );
    }

    public function findByEmailAndCode($email, $code)
    {
        $code =  VerificationCode::where('email', $email)->where('code', $code)->orderby('created_at', 'desc')->first();
        
        if(!$code || $code->expired < now()) {
            return false;
        }

        return $code;
    }
}
