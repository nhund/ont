<?php

namespace App\Http\Controllers\Api\Lesson;

use App\Components\Lesson\LessonService;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Transformers\Lesson\LessonTransformer;
use Illuminate\Http\Request;

class LessonController extends Controller{

    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function index(){}

    /**
     * @param Lesson $lesson
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Lesson $lesson, Request $request){

        return fractal()
            ->item($lesson, new LessonTransformer)
            ->respond();

    }

    public function store(){}

    public function update(){}

    public function delete(){}
}