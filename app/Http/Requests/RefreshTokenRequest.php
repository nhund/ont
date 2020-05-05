<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 17:09
 */

namespace App\Http\Requests;


class RefreshTokenRequest extends AuthorizedFormRequest
{
    public function rules()
    {
        return [
            'client_id' => 'required|string|exists:oauth_clients,id',
            'refresh_token' => 'required|string',
            'scope' => 'string',
        ];
    }
}