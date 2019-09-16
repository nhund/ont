<?php


namespace App\Components\Auth\Social;


use App\User;
use Illuminate\Support\Arr;
use Laravel\Socialite\Facades\Socialite;

class FacebookService
{
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

    /**
     * {@inheritdoc}
     */
    public function getUserByToken($token)
    {
        $fields = $this->getFields();
        $driver = Socialite::driver('facebook');

        if (empty($fields) || !method_exists($driver, 'fields')) {
            return $driver;
        }

        return $driver->fields($fields)->userFromToken($token);
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