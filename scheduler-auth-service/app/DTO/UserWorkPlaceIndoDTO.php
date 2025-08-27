<?php

namespace App\DTO;

class UserWorkPlaceIndoDTO
{
    public function __construct(
        public string $organization,
        public string $organization_size,
        public bool $is_agency,
        public string $country,
        public string $time_zone,
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            organization: $request->input('organization'),
            organization_size: $request->input('organization_size'),
            is_agency: $request->input('is_agency'),
            country: $request->input('country'),
            time_zone: $request->input('time_zone'),
        );
    }
}
