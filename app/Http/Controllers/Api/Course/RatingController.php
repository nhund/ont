<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 09/10/2019
 * Time: 14:25
 */

namespace App\Http\Controllers\Api\Course;

use App\Exceptions\BadRequestException;
use App\Http\Controllers\Controller;
use App\Http\Requests\RatingCourseRequest;
use App\Models\Course;
use App\Models\Rating;
use App\Transformers\Course\RatingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class RatingController extends Controller
{

    /**
     * @param Request $request
     * @param $courseId
     * @return mixed
     */
    public function index(Request $request, $courseId)
    {
        $rates = Rating::where('course_id',$courseId)->orderBy('id','DESC')->paginate();

        return fractal()
            ->collection($rates, new RatingTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($rates))
            ->respond();
    }

    public function store(Course $course, RatingCourseRequest $request)
    {
        $user = $request->user();

        $ratingValue = $request->get('rating_value');

        $userRating = Rating::where('user_id',$user->id)
            ->where('course_id', $course->id)->first();

        $rating_old = 0;
        if($userRating)
        {
            if($userRating->rating_value == $ratingValue)
            {
                return fractal()
                    ->item($userRating, new RatingTransformer)
                    ->respond();
            }
            $rating_old = $userRating->rating_value;

            $userRating->rating_value = $ratingValue;
        }else{
            $userRating = new Rating();
            $userRating->user_id = $user->id;
            $userRating->course_id = $course->id;
            $userRating->rating_value = $ratingValue;
            $userRating->create_at = time();
        }
        if($userRating->save())
        {
            if((int)$ratingValue > 0 && (int)$ratingValue < 6)
            {
                if((int)$ratingValue == 1) {$course->rating_1 += 1;}
                if((int)$ratingValue == 2) {$course->rating_2 += 1;}
                if((int)$ratingValue == 3) {$course->rating_3 += 1;}
                if((int)$ratingValue == 4) {$course->rating_4 += 1;}
                if((int)$ratingValue == 5) {$course->rating_5 += 1;}
                $course->save();
            }
            if((int)$rating_old > 0 && (int)$rating_old < 6)
            {
                if((int)$rating_old == 1 && $course->rating_1 > 0) {$course->rating_1 -= 1;}
                if((int)$rating_old == 2 && $course->rating_2 > 0) {$course->rating_2 -= 1;}
                if((int)$rating_old == 3 && $course->rating_3 > 0) {$course->rating_3 -= 1;}
                if((int)$rating_old == 4 && $course->rating_4 > 0) {$course->rating_4 -= 1;}
                if((int)$rating_old == 5 && $course->rating_5 > 0) {$course->rating_5 -= 1;}
                $course->save();
            }
            return fractal()
                ->item($userRating, new RatingTransformer)
                ->respond();
        }else{
            throw  new BadRequestException('Gửi đánh giá không thành công.');
        }
    }
}