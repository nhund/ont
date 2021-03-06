<?php

namespace App\Transformers\Category;

use App\Transformers\Course\ShortCourseTransformer;
use App\Models\Category;
use App\Models\Course;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract {
    
    protected $availableIncludes = ['course'];

    public function transform(Category $category){

        return [
            'id' => $category->id,
            'name' => $category->name,
            'type' => $category->type,
        ];
    }

    public function includeCourse(Category $category){
        
        $courses = $category->course()->where('sticky', Course::STICKY)->limit(8)->get();

        return  $courses ? $this->collection($courses, new ShortCourseTransformer) : null;
    }
}