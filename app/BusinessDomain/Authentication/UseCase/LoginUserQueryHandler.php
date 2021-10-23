<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase;

use App\BusinessDomain\Authentication\Service\AuthenticationService;
use App\BusinessDomain\Authentication\UseCase\Query\LoginUserQuery;

class LoginUserQueryHandler
{
    private AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(LoginUserQuery $query): array
    {
        return $this->authService->login($query->getEmail(), $query->getPassword());
    }
}
