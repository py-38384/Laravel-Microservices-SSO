<?php

namespace App\DTO;

class UserInterestDTO
{
    public function __construct(
        public string $interest_type,
        public array $interests
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            interest_type: $request->input('interest_type'),
            interests: $request->input('interests')
        );
    }
}
