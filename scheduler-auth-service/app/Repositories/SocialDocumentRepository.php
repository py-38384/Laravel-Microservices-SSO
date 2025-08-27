<?php

namespace App\Repositories;

use App\DTO\SocialDocumentDTO;
use App\Models\Document;
use App\Models\UserSocialAccount;

class SocialDocumentRepository
{
    public function createForUser(int $userId, SocialDocumentDTO $dto)
    {
        return UserSocialAccount::create([
            'user_id' => $userId,
            'title'   => $dto->title,
            'pages'   => $dto->pages,
        ]);
    }
}
