<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

/**
 * AuthController Class
 * AuthController is responsible to handle user auth flows : register user, login user
 */
class AuthController extends Controller
{
    /* @var AuthRepository */
    protected AuthRepository $authRepository;

    /* @var AuthService */
    protected AuthService $authService;

    /**
     * AuthController Constructor
     * @param AuthService $authService
     * @param AuthRepository $authRepository
     */
    public function __construct(
        AuthService $authService,
        AuthRepository $authRepository
    )
    {
        $this->authService = $authService;
        $this->authRepository = $authRepository;
    }

    /**
     * AuthController
     * Method to Register new Users
     * @param UserRegisterRequest $authRequest
     * @return JsonResponse
     */
    public function RegisterUser(UserRegisterRequest $authRequest): JsonResponse
    {
        $data = $authRequest->validated();
        $name = Arr::get($data, 'name');
        $email = Arr::get($data, 'email');
        $password = Arr::get($data, 'password');

        $user = $this->authService->RegisterUser($name, $email, $password);
        $accessToken = $user->createToken('AuthToken');

        return Response()->json(['user' => Auth::user(), 'token' => $accessToken])->setStatusCode(200);
    }

    /**
     * LoginUser
     * Method to Login Users
     * @param UserLoginRequest $userLoginRequest
     * @return JsonResponse
     */
    public function LoginUser(UserLoginRequest $userLoginRequest): JsonResponse
    {
        $data = $userLoginRequest->validated();
        $email = Arr::get($data, 'email');
        $password = Arr::get($data, 'password');

        $response = $this->authService->LoginUser($email, $password);

        return Response()->json($response)->setStatusCode(200);
    }

    /**
     * AuthenticatedUser
     * Method to return Authenticated user details
     */
    public function AuthenticatedUser(): JsonResponse
    {
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }
}
