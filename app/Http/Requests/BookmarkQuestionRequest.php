<?php

namespace App\Http\Requests;

class BookmarkQuestionRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       return [
            'type' => 'required|numeric|in:1,2',
        ];
    }
}
