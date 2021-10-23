<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\Service;

use App\Exceptions\Authentication\InvalidPasswordException;
use App\Exceptions\Authentication\UserNotFoundException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
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

    public function login(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (null === $user) {
            throw new UserNotFoundException();
        }

        if (Auth::attempt(['email' => $email,'password' => $password])) {
            $token  = $user->createToken('token')->plainTextToken;
            return [
                'user' => $user,
                'token' => $token
            ];
        }

        throw new InvalidPasswordException();
    }

    public function logout(): bool
    {
        return null !== Auth::user();
    }

    public function getLoggedInUser(): ?Authenticatable
    {
        return Auth::user();
    }
}
