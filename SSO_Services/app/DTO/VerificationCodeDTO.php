<?php

namespace App\DTO;

class VerificationCodeDTO
{
    public string $email;
    public string $code;
    public string $expired;

    public function __construct(string $email, string $code, string $expired)
    {
        $this->email = $email;
        $this->code = $code;
        $this->expired = $expired;
    }

    public static function fromUser($user, string $code, int $expiryMinutes = 5): self
    {
        
        return new self(
            email: $user->email,
            code: $code,
            expired: now()->addMinutes($expiryMinutes)->toDateTimeString()
        );
    }

    public function toArray(): array
    {
        return [
            'email'   => $this->email,
            'code'    => $this->code,
            'expired' => $this->expired
        ];
    }
}
