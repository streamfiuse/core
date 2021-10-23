<?php

declare(strict_types=1);

namespace App\BusinessDomain\Authentication\UseCase\Query\Builder;

use App\BusinessDomain\Authentication\UseCase\Query\RegisterUserQuery;

class RegisterUserQueryBuilder
{
    public function build(
        string $email,
        string $name,
        string $password
    ): RegisterUserQuery {
        return new RegisterUserQuery(
            $email,
            $name,
            $password
        );
    }
}
