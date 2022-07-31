<?php

namespace App\Http\Repositories;

use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Hash;
use JsonException;

/**
 * AuthRepository Class
 * AuthRepository is responsible for Registering/logging-in/logging-out users
 * @package App\http\Repository
 */
class AuthRepository
{
    /**
     * Register new user
     * @param string $voucher
     * @param string $email
     * @param string $password
     * @return User
     * @throws JsonException
     */
    public function RegisterUser(string $voucher, string $email, string $password): User
    {
        $voucher = Voucher::where('voucher', $voucher)->first();

        if (!$voucher) {
            throw new JSONException("Voucher doesn't exist");
        } else {
            $user = new User();
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->save();

            $voucher->delete();
        }

        return $user;
    }
}
