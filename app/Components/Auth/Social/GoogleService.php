<?php


namespace App\Components\Auth\Social;


use App\Exceptions\SocialAuthenticationException;
use Carbon\CarbonImmutable;
use http\Exception;
use Illuminate\Support\Arr;
use Laravel\Socialite\Contracts\User;
use Zttp\Zttp;

class GoogleService
{
    const TOKEN_INFO_API = 'https://www.googleapis.com/oauth2/v3/tokeninfo';

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'google';
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return [
            'email',
            'name',
            'given_name',
            'family_name',
            'gender',
            'link',
            'picture',
            'verified_email',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseIdColumn()
    {
        return 'google_id';
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseVerificationColumn()
    {
        return 'google';
    }

    /**
     * {@inheritdoc}
     * @see https://developers.google.com/identity/sign-in/web/backend-auth
     */
    public function verifyAccessToken($token)
    {
        try {
            /** @var \Zttp\ZttpResponse $response */
            $response = Zttp::post(self::TOKEN_INFO_API, [
                'access_token' => $token,
            ]);

            if (!$response->isSuccess()) {
                return false;
            }

            $data = $response->json();
            $audience = Arr::get($data, 'aud');
            $expiry = Arr::get($data, 'exp');

            return !empty($audience) && CarbonImmutable::createFromTimestamp($expiry)->gte(now());
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param User $socialUser
     * @return array
     */
    public function mapSocialUserToAttributes(User $socialUser)
    {
        $rawData = $socialUser->getRaw();
        $socialId = $this->getDatabaseIdColumn();

        $attributes = [
            $socialId => $socialUser->getId(),
            'email' => $this->getSocialEmail($socialUser),
            'first_name' => Arr::get($rawData, 'given_name'),
            'last_name' => Arr::get($rawData, 'family_name'),
        ];

        $gender = Arr::get($rawData, 'gender');
        if ($gender) {
            Arr::set($attributes, 'gender', ucfirst($gender));
        }

        return $attributes;
    }

    /**
     * @param $socialUser
     * @return string
     */
    public function getSocialEmail($socialUser)
    {
        $email = $socialUser->getEmail();

        if (!$email) {
            $email = $socialUser->getId() . '@gmail.com';
        }

        return $email;
    }
}