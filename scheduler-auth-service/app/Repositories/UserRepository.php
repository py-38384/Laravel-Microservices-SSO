<?php

namespace App\Repositories;


use App\DTO\User\UserRegisterDTO;
use App\DTO\UserInterestDTO;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly User $model
    ) {}

    public function create(UserRegisterDTO $dto): User
    {
        return $this->model->create([
            'first_name' => $dto->firstName,
            'last_name' => $dto->lastName,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function storePasswordResetToken(string $email, string $token)
    {
        DB::table('password_resets')->updateOrInsert(
            ['email' => $email],
            ['token' => $token, 'created_at' => now()]
        );
    }

    public function getPasswordResetRecord(string $email, string $token)
    {
        return DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $token)
            ->first();
    }

    public function deletePasswordResetRecord(string $email)
    {
        DB::table('password_resets')->where('email', $email)->delete();
    }

    public function userinterest(User $user, UserInterestDTO $dto)
    {
        $user->interest_type = $dto->interest_type;
        $user->interests = json_encode($dto->interests);
        $user->save();
    }
}
