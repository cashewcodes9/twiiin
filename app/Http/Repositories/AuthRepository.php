<?php

namespace App\Http\Repositories;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class AuthRepository
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
        $user->password = bcrypt($password);
        $user->save();

        return $user;
    }

    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return Authenticatable|void|string
     */
    public function LoginUser(string $email, string $password)
    {
        if (auth()->attempt([$email, $password])) {
            //generate access token for user
            // if successful login attempt, return the access token
            auth()->user()->createToken('Login')->accessToken;
            return auth()->user();
        }
        else {
            return 'Unauthorized Access';
        }
    }
}