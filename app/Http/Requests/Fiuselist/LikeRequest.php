<?php

namespace App\Http\Requests\Fiuselist;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class LikeRequest extends FormRequest
{

    /**
     * Handle a failed validation attempt.
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        $e = new ValidationException($validator);
        $e->response = new JsonResponse([
            'status' => 'failed',
            'message' => join(' ', $e->errors()['id'])
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
        throw $e;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['id' => $this->route('id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|gt:0'
        ];
    }
}
