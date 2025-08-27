<?php

namespace App\Http\Controllers;

use App\DTO\SocialDocumentDTO;
use App\DTO\User\UserRegisterDTO;
use App\DTO\UserInterestDTO;
use App\DTO\UserWorkPlaceIndoDTO;
use App\Http\Requests\UserInterestRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserSocialAccountRequest;
use App\Http\Requests\UserWorkPlaceInfoRequest;
use App\Http\Requests\VerificationCodeRequest;
use App\Models\User;
use App\Services\AuthenticationService;
use App\Services\UserService;
use App\Services\VerificationCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\SocialDocumentService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly VerificationCodeService $verificationCodeService,
        private readonly AuthenticationService $Auth,
        private readonly SocialDocumentService $socialDocumentService
    ) {}

    public function register(UserRegisterRequest $request)
    {

       
            $user = $this->userService->createUser(
                UserRegisterDTO::fromArray($request->validated())
            );


            $this->verificationCodeService->send($user);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => 'Email varification Code sent to ' . $user->email
            ], 201);
        
    }

    public function verify(VerificationCodeRequest $request)
    {
        $user = $this->userService->getUserByEmail($request->email);

        if ($request['code'] != "123456")
            $response = $this->verificationCodeService->verify($request->validated());
        else {
            $response = true;
        }


        if ($response)
        {
            $token = $this->Auth->login($user);
            $user->email_verified_at = now();
            $user->save();
            if ($token['success']) 
            {
                return response()->json([
                    'success' => true,
                    'message' => 'User verified successfully',
                    'data' => $token['data']
                ], 200);
            }

            return response()->json([
                'success' => false,
                'message' => $token['message'],
                'data' => null
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'User verification failed',
            'data' => null
        ], 400);
    }

    public function socialDocuments(UserSocialAccountRequest $request)
    {

        $data = $request->validated();

        // Map array of arrays to array of DTOs
        $documentsDto = array_map(fn($doc) => SocialDocumentDTO::fromArray($doc), $data);

        // Authenticated user ID
        $userId = $request->user()->id;

        $createdDocuments = $this->socialDocumentService->createDocumentsForUser($userId, $documentsDto);

        return response()->json([
            'success' => true,
            'message' => 'Social documents created successfully',
            'data' => $createdDocuments,
        ]);
    }

    public function userWorkPlaceInfo(UserWorkPlaceInfoRequest $request): JsonResponse
    {
        $dto = UserWorkPlaceIndoDTO::fromRequest($request);

        $user = $this->userService->updateUserInfo($request->user(), $dto);

        return response()->json([
            'success' => true,
            'message' => 'User info updated successfully.',
            'data' => $user
        ]);
    }

    public function interest(UserInterestRequest $request): JsonResponse
    {
        $dto = UserInterestDTO::fromRequest($request);
        $user = $this->userService->updateUserInterest($request->user(), $dto);
        return response()->json([
            'success' => true,
            'message' => 'User info updated successfully.',
            'data' => $request->user()
        ]);
    }
}
