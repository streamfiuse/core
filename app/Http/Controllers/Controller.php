<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\RequestInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function validateRequest(RequestInterface $request): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($request->all(), $request->rules());
    }
}
