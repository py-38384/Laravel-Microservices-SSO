<?php

namespace App\Services;

use App\Models\User;
use App\Models\Token;
use App\DTO\UserLoginDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use function PHPUnit\Framework\isObject;

class AuthManagementService
{
    /**
     * Create a new class instance.
     */
    public string $login_url;
    public string $checkTokenUrl;

    public function __construct()
    {
        $this->login_url = config('app.auth_server_url') . "/api/v1/users/login";
        $this->checkTokenUrl = config('app.auth_server_url') . "/api/user";
    }
    public function createUserObject(string $name,string $email, string $password){
        return User::create([
            "name" => $name,
            "email" => $email,
            "password" => $password,
        ]);
    }
    public function createOrUpdateUserToken(User $user, string $token){
        return $user->token()->updateOrCreate(
            [],
            ["token" => $token]
        );
    }
    public function returnValue(bool $success, string | null $token, $data, $isObject = false, $isCollection = false,){
        if($isObject){
            return (object)["success" => $success, "token" => $token, "responseData" => $data];
        }
        if($isCollection){
            return collect(["success" => $success, "token" => $token, "responseData" => $data]);
        }
        return ["success" => $success, "token" => $token, "responseData" => $data];
    }
    public function loginAndGetToken(UserLoginDTO $dto){
        $response = Http::accept('application/json')
            ->post($this->login_url, [
                'email' => $dto->email,
                'password' => $dto->password,
            ]);
        $data = $response->json();
        if ($data) {
            if($data["success"]){
                $token = $data["data"];
                $user_data = $this->checkTokenValidation($token, $dto->email)['responseData'];
                return $this->returnValue(success: true, token: $token, data: $user_data);
            };
            return $this->returnValue(success: false, token: null, data: $data);
        }
        return $this->returnValue(success: false, token: null, data: ["message" => "Invaild Response"]);
    }
    public function checkTokenValidation(string $token, string $email){
        $response = Http::withToken($token)->accept('application/json')
        ->get($this->checkTokenUrl);
        $data = $response->json();
        if ($response->successful()) {
            if($data["email"] == $email){
                return $this->returnValue(success: true, token: $token, data: $data);
            }
            return $this->returnValue(success: false, token: null, data: ["message" => "User Email Didn't Matched"]);
        }
        if($data){
            return $this->returnValue(success: false, token: null, data: $data);
        }
        return $this->returnValue(success: false, token: null, data: ["message" => "Invalid Response Fron Auth Service"]);
    }
    public function getTokenUsingClientCredential(UserLoginDTO $dto, $user){
        $data = $this->loginAndGetToken($dto);
        $token = $data['token'];
        if($data["success"]){
            $user->password = $dto->password;
            $this->createOrUpdateUserToken($user, $token);
            $user->save();
        }
        return $data;
    }
    public function getToken(UserLoginDTO $dto){
        $user = User::where('email', $dto->email)->first();
        if($user){
            if (Hash::check($dto->password, $user->password)) {
                // Need To Implement Multiple Broswer login. Currently if user log out from one broswer all account from all broswer logged out.
                $token = $user->token?->token;
                if(!$token){
                    $data = $this->loginAndGetToken($dto);
                    if($data["success"]){
                        $token = $data['token'];
                        $this->createOrUpdateUserToken($user, $token);
                        return $data;
                    }
                    return $data;
                }
                $tokenVaidationResponse = $this->checkTokenValidation((string)$token, $user->email);
                if($tokenVaidationResponse["success"]){
                    session()->regenerate();
                    return $tokenVaidationResponse;
                }
            }
            return $this->getTokenUsingClientCredential($dto, $user);
        }
        $data = $this->loginAndGetToken($dto);
        if($data["success"]){
            $token = $data['token'];
            $user = $this->createUserObject($data['responseData']['first_name'].' '.$data['responseData']['last_name'],$dto->email, $dto->password);
            $this->createOrUpdateUserToken($user, $token);
            return $data;
        }
        return $data;
    }
}
