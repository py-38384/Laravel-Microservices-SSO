<?php

namespace App\Services;

use App\Notifications\VerificationCodeNotification;
use App\Repositories\VerificationCodeRepository;
use App\DTO\VerificationCodeDTO;

class VerificationCodeService
{
    protected $repository;

    public function __construct(VerificationCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function generate(): string
    {
        return random_int(100000, 999999);
    }

    public function send($user)
    {
        if (!$user) {
            return false;
        }

        $code = $this->generate();

        $dto = VerificationCodeDTO::fromUser($user, $code);

        $this->repository->updateOrCreateByEmail($dto);

        $user->notify(new VerificationCodeNotification($code));

        return true;
    }

    public function verify($request)
    {
        return $this->repository->findByEmailAndCode($request['email'], $request['code']);
    }
}
