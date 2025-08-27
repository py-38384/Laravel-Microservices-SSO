<?php

namespace App\Http\Controllers;

use App\DTO\ForgotPasswordDTO;
use App\DTO\ResetPasswordDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\ForgotPasswordService;

class ForgotPasswordController extends Controller
{
    public function __construct(private ForgotPasswordService $forgotPasswordService) {}

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $token = $this->forgotPasswordService->sendResetLink(
                new ForgotPasswordDTO($request->validated())
        );
        return response()->json(
            [
                'success'=>true,
                'message'=>"Reset link sent to " . $request->email,
                'data'=>null
            ]
        );
    }

    public function resetPassword(ResetPasswordRequest $request)
    {

        $message = $this->forgotPasswordService->resetPassword(
                new ResetPasswordDTO($request->validated())
        );

        return response()->json(
            [
                'success'=>true,
                'message'=>$message['message'],
                'data'=>null
            ]
        );
    }
}
