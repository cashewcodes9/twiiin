<?php

namespace App\Http\Controllers;


use App\Http\Requests\AuthRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function RegisterUser(AuthRequest $authRequest)
    {
        $authRequest->validated();
    }
}
