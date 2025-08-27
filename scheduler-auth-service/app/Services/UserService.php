<?php

namespace App\Services;

use App\DTO\User\UserRegisterDTO;
use App\DTO\UserInterestDTO;
use App\DTO\UserWorkPlaceIndoDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\UserWorkPlaceInfoRepository;

class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
        private readonly UserWorkPlaceInfoRepository $userWorkPlaceInfoRepository
    ) {}

    public function createUser(UserRegisterDTO $dto)
    {
        return $this->repository->create($dto);
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->repository->findByEmail($email);
    }


    public function updateUserInfo(User $user, UserWorkPlaceIndoDTO $dto): User
    {
        return $this->userWorkPlaceInfoRepository->updateUserInfo($user, $dto);
    }

    public function updateUserInterest(User $user, UserInterestDTO $dto)
    {
        return $this->repository->userinterest($user, $dto);
    }
}