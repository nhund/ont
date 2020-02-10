<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 13:57
 */

namespace App\Http\Controllers\Api\Slide;


use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Transformers\SlideTransformer;

class SlideController extends Controller
{

    /**
     * get slide for page
     * @return mixed
     */
    public function index()
    {
        $slide = Slide::getSlide();

        return fractal()
            ->collection($slide)
            ->transformWith(new SlideTransformer)
            ->respond();
    }

}