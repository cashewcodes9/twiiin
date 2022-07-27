<?php

namespace App\Http\Service;
use App\Http\Repositories\AuthRepository;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * AuthService Class
 * AuthService is responsible for serving AuthController with User Auth methods
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

    /**
     * Register User service method to register users
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function RegisterUser(string $name, string $email, string $password): User
    {
         return $this->authRepository->RegisterUser($name, $email, $password);

    }

    /**
     * @param string $email
     * @param string $password
     * @return Authenticatable|void
     */
    public function LoginUser(string $email, string $password)
    {
        return $this->authRepository->LoginUser($email, $password);
    }

}
