<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase;

use App\BusinessDomain\Authentication\Service\AuthenticationService;
use App\Models\User;

class GetLoggedInUserQuery
{
    private AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(): User    {
        return $this->authService->getLoggedInUser();
    }
}
