<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase;

use App\BusinessDomain\Authentication\Service\AuthenticationService;

class LogoutUserQueryHandler
{
    private AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(): bool
    {
        return $this->authService->logout();
    }
}
