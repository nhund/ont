<?php

namespace App\Http\Requests;

class FeedbackRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

       return [
            'type' => 'numeric|in:2',
            'title' => 'required',
            'email' => 'required',
            'content' => 'required',
        ];
    }
}
