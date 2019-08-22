<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 14:20
 */

namespace App\Http\Controllers\Api\Course;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Transformers\Course\FullCourseTransformer;
use Illuminate\Http\Request;

class CourseController extends Controller
{

    public function index(Request $request){
        $courses = Course::getCourses();

        return fractal()
            ->collection($courses)
            ->transformWith(new FullCourseTransformer)
            ->respond();
    }

    public function show(Request $request){

    }

    public function store(){}

    public function update(){}

    public function delete(){}
}