<?php

namespace App\Http\Requests\Book;

use App\Author;
use App\Category;
use App\Http\Requests\Api\FormRequest;

class Create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|string|min:1|max:150',
            'author_id' => 'required|exists:' . Author::getFullConnectionName() . ',id',
            'category_id' => 'required|exists:' . Category::getFullConnectionName() . ',id'
        ];
    }
}
