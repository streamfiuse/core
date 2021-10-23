<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase\Query\Builder;

use App\BusinessDomain\Authentication\UseCase\Query\LoginUserQuery;

class LoginUserQueryBuilder
{
    public function build(string $email, string $password): LoginUserQuery
    {
        return new LoginUserQuery(
            $email,
            $password
        );
    }
}
