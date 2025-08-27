<?php

namespace App\Services;


use App\DTO\SocialDocumentDTO;
use App\Repositories\SocialDocumentRepository;

class SocialDocumentService
{
    public function __construct(
        protected SocialDocumentRepository $repository
    ) {}

    /**
     * Create multiple documents for a user
     *
     * @param int $userId
     * @param SocialDocumentDTO[] $documents
     * @return array
     */
    public function createDocumentsForUser(int $userId, array $documents): array
    {
        $created = [];
        foreach ($documents as $dto) {
            $created[] = $this->repository->createForUser($userId, $dto);
        }
        return $created;
    }
}
