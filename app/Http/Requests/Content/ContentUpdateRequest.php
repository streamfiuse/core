<?php

namespace App\Http\Requests\Content;

use App\Http\Requests\RequestInterface;
use Illuminate\Foundation\Http\FormRequest;

class ContentUpdateRequest extends FormRequest implements ContentRequestInterface, RequestInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string|unique:content,title',
            'release_date' => 'date_format:Y-m-d',
            'content_type' => 'string',
            'genre' => 'json',
            'tags' => 'json',
            'runtime' => 'integer|gt:0',
            'short_description' => 'string',
            'cast' => 'json',
            'directors' => 'json',
            'age_restriction' => 'string',
            'poster_url' => 'url',
            'youtube_trailer_url' => 'url',
            'production_company' => 'string',
            'seasons' => 'integer|gt:0',
            'average_episode_count' => 'integer|gt:0',
        ];
    }
}
