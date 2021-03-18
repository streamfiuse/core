<?php


namespace App\Http\Requests\Fiuselist;


use App\Http\Requests\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class FiuselistAddContentRequest extends FormRequest implements FiuselistRequestInterface, RequestInterface
{

    public function rules(): array
    {
        return [
            'content_id' => 'required',
            'like_status' => 'required'
        ];
    }
}
