<?php

declare(strict_types=1);

namespace App\Http\Requests;

interface RequestInterface
{
    public function rules(): array;
    public function all($keys = null);
}
