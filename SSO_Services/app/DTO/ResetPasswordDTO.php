<?php
namespace App\DTO;

class ResetPasswordDTO
{
    public string $email;
    public string $token;
    public string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->token = $data['token'];
        $this->password = $data['password'];
    }
}
