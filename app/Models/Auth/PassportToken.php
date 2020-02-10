<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 21/08/2019
 * Time: 16:14
 */

namespace App\Models\Auth;

use Exception;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class PassportToken extends Token
{

    /**
     * Parse a given token string to fetch the associated token model instance.
     *
     * @param  string $tokenString
     * @return static|null
     */
    public static function parseToken($tokenString)
    {
        if (is_null($tokenString)) {
            return null;
        }

        try {
            $tokenId = (new Parser)->parse($tokenString)->getHeader('jti');
        } catch (Exception $e) {
            return null;
        }

        if ($tokenId) {
            return static::where('id', $tokenId)->first();
        }

        return null;
    }

}