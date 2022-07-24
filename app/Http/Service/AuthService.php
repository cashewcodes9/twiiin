<?php

namespace App\Http\Service;
use App\Http\Repositories\AuthRepository;
use Laravel\Sanctum\NewAccessToken;

/**
 * Class AuthService
 * Class AuthService is responsible for operation on  user Auth
 */
class AuthService
{
    /* @var AuthRepository */
    protected AuthRepository $authRepository;

    /**
     * AuthService Constructor
     * @param AuthRepository $authRepository
     */
    public function __construct(
        AuthRepository $authRepository
    )
    {
        $this->authRepository = $authRepository;
    }

    public function RegisterUser(string $name, string $email, string $password): NewAccessToken
    {
         $user = $this->authRepository->RegisterUser($name, $email, $password);

         return $user->createToken('Register');
    }

    public function LoginUser(string $email, string $password)
    {
        return $this->authRepository->LoginUser($email, $password);
    }

}
