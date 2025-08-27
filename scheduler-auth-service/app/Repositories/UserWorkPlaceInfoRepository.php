<?php

namespace App\Repositories;

use App\Models\User;
use App\DTO\UserInfoDTO;
use App\DTO\UserWorkPlaceIndoDTO;

class UserWorkPlaceInfoRepository
{
    public function updateUserInfo(User $user, UserWorkPlaceIndoDTO $dto): User
    {
        $user->organization = $dto->organization;
        $user->organization_size = $dto->organization_size;
        $user->is_agency = $dto->is_agency;
        $user->country = $dto->country;
        $user->time_zone = $dto->time_zone;

        $user->save();

        return $user;
    }
}
