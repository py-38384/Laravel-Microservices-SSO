<?php

namespace App\DTO;

class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            email: $request->input('email'),
            password: $request->input('password')
        );
    }
}
