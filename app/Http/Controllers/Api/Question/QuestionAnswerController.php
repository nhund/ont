<?php

namespace App\Http\Controllers\Api\Question;

use App\Components\Question\QuestionAnswerService;
use App\Http\Controllers\Controller;
use App\Http\Requests\submitQuestionRequest;
use App\Models\Question;

class QuestionAnswerController extends Controller{

    protected $questionAnswerService;

    public function __construct(QuestionAnswerService $questionAnswerService)
    {
        $this->questionAnswerService = $questionAnswerService;
    }

    public function index(){}
        
    public function show(){}

    public function store(Question $question, submitQuestionRequest $request)
    {
        $this->authorize('submit', $question);

       $result = $this->questionAnswerService->submit($request, $question);

      return $this->respondOk($result);
    }

    public function update(){}

    public function delete(){}
}