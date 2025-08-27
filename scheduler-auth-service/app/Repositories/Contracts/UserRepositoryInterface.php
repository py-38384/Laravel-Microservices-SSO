<?php

namespace App\Repositories\Contracts;


use App\DTO\User\UserRegisterDTO;
use App\DTO\UserInterestDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserRegisterDTO $dto): User;
    public function findByEmail(string $email): ?User;
    public function userinterest(User $user, UserInterestDTO $dto);
} 