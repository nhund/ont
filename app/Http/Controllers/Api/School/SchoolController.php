<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 22/08/2019
 * Time: 15:45
 */

namespace App\Http\Controllers\Api\School;


use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Transformers\Category\CategoryTransformer;
use Illuminate\Http\Request;
use App\Components\Course\CourseService;
use App\Transformers\Course\ShortCourseTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class SchoolController extends Controller
{
    public function index(Request $request){

        $categories = Category::where('status',Category::STATUS_ON)->get();

        return fractal()
            ->collection($categories)
            ->transformWith(new CategoryTransformer)
            ->respond();
    }

    public function show(Request $request){

    }

    public function store(){}

    public function update(){}

    public function delete(){}
}