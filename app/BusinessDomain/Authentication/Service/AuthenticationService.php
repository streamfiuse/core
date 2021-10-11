<?php

namespace App\BusinessDomain\Authentication\Service;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthenticationService
{
    public function register(string $email, string $name, string $password): User
    {
        $passwordHash = Hash::make($password);
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $passwordHash
        ]);
    }
}
