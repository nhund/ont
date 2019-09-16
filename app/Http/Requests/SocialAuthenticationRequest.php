<?php

namespace App\Http\Requests;

class SocialAuthenticationRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $mobileClient = $this->mobileClient();

        $rules = [
            'token' => 'required|string',
        ];

        if ($mobileClient === 'web') {
            return $rules;
        }

        return array_merge($rules, [
            'client_id' => 'bail|required|string|exists:oauth_clients,id',
            'client_secret' => 'required|string',
        ]);
    }
}
