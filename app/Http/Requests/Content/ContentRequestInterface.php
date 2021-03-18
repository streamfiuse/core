<?php


namespace App\Http\Requests\Content;


interface ContentRequestInterface
{
    public function rules(): array;
    public function all($keys = null);
}
