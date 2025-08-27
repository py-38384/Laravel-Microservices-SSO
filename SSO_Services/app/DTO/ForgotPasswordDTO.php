<?php
namespace App\DTO;

class ForgotPasswordDTO
{
    public string $email;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
    }
}
