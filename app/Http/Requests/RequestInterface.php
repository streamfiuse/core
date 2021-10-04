<?php

namespace App\Http\Requests;

interface RequestInterface
{
    public function rules(): array;
    public function all($keys = null);
}
