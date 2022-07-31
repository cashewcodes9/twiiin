<?php

namespace App\Http\Service;
use App\Http\Repositories\AuthRepository;
use App\Models\User;

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
     * @param string $voucher
     * @param string $email
     * @param string $password
     * @return User
     */
    public function RegisterUser(string $voucher, string $email, string $password): User
    {
         return $this->authRepository->RegisterUser($voucher, $email, $password);

    }

}
