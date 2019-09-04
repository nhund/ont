<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 15:45
 */

namespace App\Http\Controllers\Api\School;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use App\Transformers\Course\ShortCourseTransformer;

class SchoolController extends Controller
{
    public function index($school_id, Request $request){
        $shools = (new CourseService($request))->getCourseOfSchoolForHomePage($school_id);

        return fractal()
            ->collection($shools)
            ->transformWith(new ShortCourseTransformer)
            ->respond();
    }

    public function show(Request $request){

    }

    public function store(){}

    public function update(){}

    public function delete(){}
}