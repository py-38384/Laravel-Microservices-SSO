<?php

namespace App\Http\Controllers;

use App\DTO\UserLoginDTO;
use App\Http\Requests\LoginRequest;
use App\Services\AuthenticationService;
use Illuminate\Events\Login;
use Illuminate\Container\Attributes;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $auth;
    public function __construct(AuthenticationService $Auth)
    {
        $this->auth = $Auth;
    }

    public function login(LoginRequest $request)
    {
        $dto = UserLoginDTO::fromRequest($request);
        $token = $this->auth->userLogin($dto);

        if(!$token['success'])
            return response()->json($token, 401);

        return response()->json($token, 200);
    }
}
