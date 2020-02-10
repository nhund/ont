<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:04
 */

namespace App\Transformers;

use App\Models\School;
use League\Fractal\TransformerAbstract;

class SchoolTransformer extends TransformerAbstract
{

    public function transform(School $school)
    {
        return [
            'id'          => $school->id,
            'name'       => $school->name,
        ];
    }
}