<?php

namespace App\Http\Controllers;


use App\Http\Repositories\AuthRepository;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /* @var AuthRepository */
    protected AuthRepository $authRepository;

    /* @var AuthService */
    protected AuthService $authService;

    public function __construct(
        AuthService $authService,
        AuthRepository $authRepository
    )
    {
        $this->authService = $authService;
        $this->authRepository = $authRepository;
    }

    public function RegisterUser(AuthRequest $authRequest): JsonResponse
    {
        $data = $authRequest->validated();
        $name = Arr::get($data, 'name');
        $email = Arr::get($data, 'email');
        $password = Arr::get($data, 'password');

        $accessToken = $this->authService->RegisterUser($name, $email, $password);

        return Response()->json($accessToken)->setStatusCode(200);
    }

    public function LoginUser(UserLoginRequest $userLoginRequest)
    {
        $data = $userLoginRequest->validated();
        $email = Arr::get($data, 'email');
        $password = Arr::get($data, 'password');

        $response = $this->authService->LoginUser($email, $password);

        return Response()->json($response)->setStatusCode(200);
    }
}
