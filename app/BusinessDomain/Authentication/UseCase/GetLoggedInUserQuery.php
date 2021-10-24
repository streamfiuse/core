<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase;

use App\BusinessDomain\Authentication\Service\AuthenticationService;
use Illuminate\Contracts\Auth\Authenticatable;

class GetLoggedInUserQuery
{
    private AuthenticationService $authService;

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function execute(): ?Authenticatable
    {
        return $this->authService->getLoggedInUser();
    }
}
