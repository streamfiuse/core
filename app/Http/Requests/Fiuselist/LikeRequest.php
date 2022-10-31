<?php

namespace App\Http\Requests\Fiuselist;

use Illuminate\Foundation\Http\FormRequest;

class LikeRequest extends FormRequest
{

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
