<?php

namespace App\DTO;

class SocialDocumentDTO
{
    public function __construct(
        public string $title,
        public array $pages
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            pages: $data['pages']
        );
    }
}
