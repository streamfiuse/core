<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class ContentStoreRequest extends FormRequest implements ContentRequestInterface
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:content,title',
            'release_date' => 'required|date_format:Y-m-d',
            'content_type' => 'required|string',
            'genre' => 'required|json',
            'tags' => 'required|json',
            'runtime' => 'required|integer|gt:0',
            'short_description' => 'required|string',
            'cast' => 'required|json',
            'directors' => 'required|json',
            'age_restriction' => 'required|string',
            'poster_url' => 'required|url',
            'youtube_trailer_url' => 'required|url',
            'production_company' => 'required|string',
            'seasons' => 'required|integer|gt:0',
            'average_episode_count' => 'required|integer|gt:0',
        ];
    }
}
