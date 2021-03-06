<?php

namespace App\Http\Requests;

use App\Components\Auth\Social\SocialService;

class SocialAuthenticationRequest extends AuthorizedFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $provider = $this->route()->parameter('provider');

        $rules = [];

        if ($provider == SocialService::FACEBOOK || $provider == SocialService::GOOGLE){
            $rules = [
                'id' => 'required|string',
                'email' => 'required|email|string',
                'name' => 'required|string',
            ];
        }

        return $rules;

//        $mobileClient = $this->mobileClient();
//
//        $rules = [
//            'token' => 'required|string',
//        ];
//
//        if ($mobileClient === 'web') {
//            return $rules;
//        }
//
//        return array_merge($rules, [
//            'client_id' => 'bail|required|string|exists:oauth_clients,id',
//            'client_secret' => 'required|string',
//        ]);
    }

    public function messages()
    {
        return [
            'fb_id.required' => 'Mã facebook Id không được để trống',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'name.required' => 'Tên không được để trống.',
        ];
    }
}
