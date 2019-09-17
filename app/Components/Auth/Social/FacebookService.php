<?php


namespace App\Components\Auth\Social;


use App\User;
use Illuminate\Support\Arr;
use Zttp\Zttp;

class FacebookService
{
    const TOKEN_INFO_API = 'https://graph.facebook.com/v3.0/me';

    protected $token;

    public function __construct($token = null)
    {
        $this->token = $token;
    }
    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return [
            'name',
            'first_name',
            'last_name',
            'email',
            'gender',
            'link',
            'birthday',
            'location',
        ];
    }

    public function checkLogin()
    {

    }


    /**
     * @param $token
     * @return bool
     */
    public function getUserByToken($token)
    {
//        $fields = $this->getFields();
//        $driver = Socialite::driver('facebook');
//        if (empty($fields) || !method_exists($driver, 'fields')) {
//            return $driver;
//        }
//        return $driver->fields($fields)->userFromToken($token);

        $fields = $this->getFields();

        try {
            $response = Zttp::get(self::TOKEN_INFO_API, [
                'access_token' => $token,
                'fields' => implode($fields, ',')
            ]);
            if (!$response->isSuccess()) {
                return false;
            }
            return $response->json();
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabaseIdColumn()
    {
        return 'fb_id';
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
            'first_name' => Arr::get($rawData, 'first_name'),
            'last_name' => Arr::get($rawData, 'last_name'),
        ];

        $gender = Arr::get($rawData, 'gender');
        if ($gender) {
            Arr::set($attributes, 'gender', ucfirst($gender));
        }

        $location = Arr::get($rawData, 'location.name');
        if ($location) {
            Arr::set($attributes, 'live', $location);
        }

//        $birthday = Arr::get($rawData, 'birthday');
//        try {
//            CarbonImmutable::createFromFormat('d/m/Y', $birthday);
//            $birthday = date('Y-m-d', strtotime($birthday));
//        } catch (Exception $e) {
//            $birthday = null;
//        }

//        if ($birthday) {
//            Arr::set($attributes, 'dob', $birthday);
//        }

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
            $email = $socialUser->getId() . '@fb.com';
        }

        return $email;
    }
}