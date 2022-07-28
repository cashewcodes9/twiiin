<?php

namespace App\Http\Repositories;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * AuthRepository Class
 * AuthRepository is responsible for Registering/logging-in/logging-out users
 * @package App\http\Repository
 */
class AuthRepository
{
    /**
     * Register new user
     * @param string $name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function RegisterUser(string $name, string $email, string $password): User
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
