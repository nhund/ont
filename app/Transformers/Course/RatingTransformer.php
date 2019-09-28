<?php

namespace App\Transformers\Course;

use App\Models\Course;
use App\Models\Rating;
use App\Transformers\User\UserFull;
use League\Fractal\TransformerAbstract;

class RatingTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];
    /**
     * A Fractal transformer Course.
     *
     * @param Rating $rating
     * @return array
     */
    public function transform(Rating $rating)
    {
        return $rating->toArray();
    }

    /**
     * @param Rating $rating
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeUser(Rating $rating)
    {
        $user = $rating->user;

        return $user ? $this->item($user, new UserFull) : null;
    }
}
