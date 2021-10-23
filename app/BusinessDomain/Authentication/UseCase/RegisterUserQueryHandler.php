<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase;

use App\BusinessDomain\Authentication\Service\AuthenticationService;
use App\BusinessDomain\Authentication\UseCase\Query\RegisterUserQuery;
use App\Models\User;

class RegisterUserQueryHandler
{
    private AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(RegisterUserQuery $query): User
    {
        return $this->authService->register(
            $query->getEmail(),
            $query->getName(),
            $query->getPassword()
        );
    }
}
