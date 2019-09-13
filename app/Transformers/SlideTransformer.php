<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:04
 */

namespace App\Transformers;


use App\Models\Slide;
use League\Fractal\TransformerAbstract;

class SlideTransformer extends TransformerAbstract
{

    public function transform(Slide $slide)
    {
        return [
            'id'          => $slide->id,
            'title'       => $slide->title,
            'url'         => $slide->url,
            'img'         => asset($slide->img),
            'content'     => $slide->content,
            'slide_order' => $slide->slide_order,
        ];
    }
}