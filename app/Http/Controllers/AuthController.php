<?php

namespace App\Http\Controllers;

use App\Http\Repositories\AuthRepository;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Service\AuthService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $token = $user->createToken('AuthToken');

        return Response()->json(['accessToken' => $token->accessToken])->setStatusCode(200);
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

        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('Laravel Personal Access Client');

                return Response()->json(['accessToken' => $token->accessToken])->setStatusCode(200);
            } else {
                return Response()->json(['message' => "Password mismatch"])->setStatusCode(422);
            }
        } else {
            return Response()->json(['message' => 'User does not exist']);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        Response()->json(['message' => 'You have been successfully logged out!'])->setStatusCode(200);
    }
}
