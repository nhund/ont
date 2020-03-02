<?php

namespace App\Http\Controllers\BackEnd;

use App\Components\Exam\ExamService;
use App\Models\Question;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use App\Models\QuestionCardMuti;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Course;
use App\Helpers\Helper;


class QuestionController extends AdminBaseController
{
    public function add(Request $request)
    {
        $data = $request->all();
        if (!isset($data['type'])) {
            return response()->json([
                'error' => true,
                'message' => 'có lỗi xẩy ra, thiếu tham số',
                'data' => []
            ]);
        }
        if (!Auth::check()) {
            return response()->json(array('error' => true, 'type' => 'login', 'msg' => 'Bạn cần đăng nhập để thực hiện hành động này'));
        }
        $user = Auth::user();
        $lesson = Lesson::find($data['lesson_id']);
        $typeLesson = $request->input('type_lesson');
        if ($data['type'] == Question::TYPE_TRAC_NGHIEM) {
            // /dd($data);
            $question = new Question();
            $question->type = $data['type'];
            $question->parent_id = 0;
            $question->lesson_id = $data['lesson_id'];
            $question->course_id = $lesson->course_id;
            $question->user_id = $user->id;
            $question->created_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->explain_before = Helper::detectMathLatex($data['explain_tn_global']);
            $question->interpret_all = Helper::detectMathLatex($data['interpret_tn_global']);
            $question->img_before = $data['image'];
            $question->audio_content = $data['audio_content'];
            $question->save();

            if ($typeLesson == Lesson::EXAM && $request->get('part_id')) {
                (new ExamService())->insertExamQuestion($question->id, $data['lesson_id'], $request->get('part_id'));
            }

            if (isset($data['question_tn']) && count($data['question_tn']) > 0) {
                foreach ($data['question_tn'] as $key => $value) {
                    if (!empty($value)) {
                        $question_sub = new Question();
                        $question_sub->type = $data['type'];
                        $question_sub->parent_id = $question->id;
                        $question_sub->lesson_id = $data['lesson_id'];
                        $question_sub->course_id = $lesson->course_id;
                        $question_sub->user_id = $user->id;
                        $question_sub->created_at = time();
                        $question_sub->question = $value;
                        $question_sub->explain_before = Helper::detectMathLatex($data['explain_tn'][$key]);
                        $question_sub->interpret = Helper::detectMathLatex($data['interpret_tn'][$key]);
                        $question_sub->img_before = $data['question_img'][$key];
                        $question_sub->audio_question = $data['audio_question_tn'][$key];
                        $question_sub->save();

                        // cau tra lơi dung
                        $as_right = new QuestionAnswer();
                        $as_right->user_id = $user->id;
                        $as_right->question_id = $question_sub->id;
                        $as_right->answer = Helper::detectMathLatex($data['answer_tn'][$key]);
                        $as_right->status = QuestionAnswer::REPLY_OK;
                        $as_right->image = $data['answer_img'][$key];
                        //$as_right->audio_answer = $data['audio_answer_tn'][$key];
                        $as_right->create_at = time();
                        $as_right->save();

                        if (isset($data['answer_error_tn']) && count($data['answer_error_tn']) > 0) {
                            foreach ($data['answer_error_tn'] as $key_as_error => $ans_er_value) {
                                if ($key_as_error == $key) {
                                    foreach ($ans_er_value as $key_item => $ans_er_value_item) {
                                        if (!empty($ans_er_value_item)) {
                                            $as_err = new QuestionAnswer();
                                            $as_err->user_id = $user->id;
                                            $as_err->question_id = $question_sub->id;
                                            $as_err->answer = Helper::detectMathLatex($ans_er_value_item);
                                            $as_err->status = QuestionAnswer::REPLY_ERROR;
                                            $as_err->image = $data['answer_img_error'][$key][$key_item];
                                            //$as_err->audio_answer = $data['audio_answer_error'][$key][$key_item];
                                            $as_err->create_at = time();
                                            $as_err->save();
                                        }

                                    }
                                }
                            }


                        }
                    }

                }
                return response()->json(array('error' => false, 'msg' => 'Thêm dữ liệu thành công'));
            }
        }
        if ($data['type'] == Question::TYPE_FLASH_MUTI) {
            //dd($data);
            $question = new Question();
            $question->type = $data['type'];
            $question->parent_id = 0;
            $question->lesson_id = $data['lesson_id'];
            $question->course_id = $lesson->course_id;
            $question->user_id = $user->id;
            $question->created_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->audio_content = $data['audio_content'];
            $question->img_before = $data['image'];
            //$question->question = $data['question'];

            if ($question->save()) {

                if ($typeLesson == Lesson::EXAM && $request->get('part_id')) {
                    (new ExamService())->insertExamQuestion($question->id, $data['lesson_id'], $request->get('part_id'));
                }

                foreach ($data['card_question'] as $key => $q_sub) {
                    if (!empty($q_sub)) {
                        $question_sub = new QuestionCardMuti();
                        $question_sub->lesson_id = $data['lesson_id'];
                        $question_sub->course_id = $lesson->course_id;
                        $question_sub->user_id = $user->id;
                        $question_sub->question_id = $question->id;
                        $question_sub->parent_id = $question->id;
                        $question_sub->question = Helper::detectMathLatex($q_sub);
                        $question_sub->audio_question = $data['audio_card_question'][$key];
                        $question_sub->question_after = Helper::detectMathLatex($data['card_question_after'][$key]);
                        $question_sub->audio_question_after = $data['audio_card_question_after'][$key];
                        $question_sub->explain_before = Helper::detectMathLatex($data['card_explain'][$key]['before']);
                        //$question_sub->audio_explain_before = $data['audio_card_explain'][$key]['before'];
                        $question_sub->explain_after = Helper::detectMathLatex($data['card_explain'][$key]['after']);
                        //$question_sub->audio_explain_after = $data['audio_card_explain'][$key]['after'];
                        $question_sub->img_before = $data['card_img_before'][$key];
                        $question_sub->img_after = $data['card_img_after'][$key];
                        $question_sub->create_at = time();
                        $question_sub->save();
                        if (isset($data['question_child']) && count($data['question_child']) > 0) {
                            foreach ($data['question_child'] as $key_child => $q_childs) {
                                if ($key_child == $key) {
                                    foreach ($q_childs as $key_child_2 => $q_child) {
                                        $question_sub_child = new QuestionCardMuti();
                                        $question_sub_child->lesson_id = $data['lesson_id'];
                                        $question_sub_child->course_id = $lesson->course_id;
                                        $question_sub_child->user_id = $user->id;
                                        $question_sub_child->question_id = $question->id;
                                        $question_sub_child->parent_id = $question_sub->id;
                                        $question_sub_child->question = Helper::detectMathLatex($q_child);
                                        $question_sub_child->audio_question = $data['audio_card_question_child'][$key][$key_child_2];
                                        $question_sub_child->question_after = Helper::detectMathLatex($data['card_question_after_child'][$key][$key_child_2]);
                                        $question_sub_child->audio_question_after = $data['audio_card_question_after_child'][$key][$key_child_2];
                                        $question_sub_child->explain_before = Helper::detectMathLatex($data['explain_before_child'][$key][$key_child_2]);
                                        $question_sub_child->explain_after = Helper::detectMathLatex($data['explain_after_child'][$key][$key_child_2]);
                                        $question_sub_child->img_before = $data['img_before_child'][$key][$key_child_2];
                                        $question_sub_child->img_after = $data['img_after_child'][$key][$key_child_2];
                                        $question_sub_child->create_at = time();
                                        $question_sub_child->save();
                                    }
                                }
                            }
                        }
                    }

                }

            }
            return response()->json(array('error' => false, 'msg' => 'Thêm dữ liệu thành công'));
        }

        if ($data['type'] == Question::TYPE_FLASH_SINGLE) {
            //dd($data);
            $question = new Question();
            $question->type = $data['type'];
            $question->parent_id = 0;
            $question->lesson_id = $data['lesson_id'];
            $question->course_id = $lesson->course_id;
            $question->user_id = $user->id;
            $question->created_at = time();
            $question->img_before = $data['img_card_before'];
            $question->img_after = $data['img_card_after'];
            $question->explain_before = Helper::detectMathLatex($data['explain']['before']);
            $question->explain_after = Helper::detectMathLatex($data['explain']['after']);
            $question->content = Helper::detectMathLatex($data['content']);
            $question->question = Helper::detectMathLatex($data['question_card']);
            $question->question_after = Helper::detectMathLatex($data['question_after_card']);
            $question->audio_content = $data['audio_content'];
            //$question->audio_explain_before = $data['audio_explain_before'];
            //$question->audio_explain_after = $data['audio_explain_after'];
            $question->audio_question = $data['audio_question_card'];
            $question->audio_question_after = $data['audio_question_card_after'];
            //dd($question);
            if ($question->save()) {
                if ($typeLesson == Lesson::EXAM && $request->get('part_id')) {
                    (new ExamService())->insertExamQuestion($question->id, $data['lesson_id'], $request->get('part_id'));
                }
                return response()->json(array('error' => false, 'msg' => 'Thêm dữ liệu thành công'));
            }
            return response()->json(array('error' => true, 'msg' => 'Thêm dữ liệu không thành công'));
        }
        if ($data['type'] == Question::TYPE_DIEN_TU) {
            //dd($data);
            if (count($data['question']) == 0) {
                return response()->json(array('error' => true, 'msg' => 'Bạn chưa tạo câu hỏi'));
            }
            $question = new Question();
            $question->type = $data['type'];
            $question->parent_id = 0;
            $question->lesson_id = $data['lesson_id'];
            $question->course_id = $lesson->course_id;
            $question->user_id = $user->id;
            $question->created_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->interpret_all = Helper::detectMathLatex($data['interpret_dt_global']);
            $question->img_before = $data['image'];
            $question->audio_content = $data['audio_content'];
            $question->save();
            if ($typeLesson == Lesson::EXAM && $request->get('part_id')) {
                (new ExamService())->insertExamQuestion($question->id, $data['lesson_id'], $request->get('part_id'));
            }
            foreach ($data['question'] as $key => $q) {
                $que = new Question();
                $que->type = $data['type'];
                $que->parent_id = $question->id;
                $que->lesson_id = $data['lesson_id'];
                $que->course_id = $lesson->course_id;
                $que->user_id = $user->id;
                $que->created_at = time();
                $que->question = Helper::detectMathLatex($q);
                $que->explain_before = Helper::detectMathLatex($data['explain'][$key]);
                $que->interpret = Helper::detectMathLatex($data['interpret'][$key]);
                $que->audio_question = $data['audio_question'][$key];
                $que->img_before = $data['image_question'][$key];
                //$que->explain_after = '';
                if ($que->save()) {
                    $an = new QuestionAnswer();
                    $an->user_id = $user->id;
                    $an->question_id = $que->id;
                    $an->answer = Helper::detectMathLatex($data['answer'][$key]);
                    $an->status = QuestionAnswer::REPLY_OK;
                    $an->image = $data['answer_dt_img'][$key];
                    //$an->audio_answer = $data['audio_answer'][$key];
                    $an->create_at = time();
                    $an->save();
                }
            }
            return response()->json(array('error' => false, 'msg' => 'Thêm dữ liệu thành công'));
        }
        if ($data['type'] == Question::TYPE_DIEN_TU_DOAN_VAN) {
            //dd($data['question']);
            if (count($data['question_dt']) == 0) {
                return response()->json(array('error' => true, 'msg' => 'Bạn chưa tạo câu hỏi'));
            }
            $question = new Question();
            $question->type = $data['type'];
            $question->parent_id = 0;
            $question->lesson_id = $data['lesson_id'];
            $question->course_id = $lesson->course_id;
            $question->user_id = $user->id;
            $question->created_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->interpret_all = Helper::detectMathLatex($data['interpret_dv_global']);
            $question->img_before = $data['image'];
            $question->save();

            if ($typeLesson == Lesson::EXAM && $request->get('part_id')) {
                (new ExamService())->insertExamQuestion($question->id, $data['lesson_id'], $request->get('part_id'));
            }

            foreach ($data['question_dt'] as $key => $q) {
                $que = new Question();
                $que->type = $data['type'];
                $que->parent_id = $question->id;
                $que->lesson_id = $data['lesson_id'];
                $que->course_id = $lesson->course_id;
                $que->user_id = $user->id;
                $que->created_at = time();
                $que->question = Helper::detectMathLatex($q);
                $que->explain_before = Helper::detectMathLatex($data['explanation'][$key]);
                $que->interpret = Helper::detectMathLatex($data['interpret_dv'][$key]);
                $que->save();
            }
            return response()->json(array('error' => false, 'msg' => 'Thêm dữ liệu thành công'));
        }
    }

    public function getTemplateFlashCard(Request $request)
    {
        $data = $request->all();
        $var = [];

        if ($data['type'] == 'child') {
            $count = (int)$data['count'];
            $count_child = (int)$data['count_child'] + 1;
            $type = $data['type'];
            return response()->json([
                'error' => false,
                'template' => view('backend.lesson.question.flash_chuoi.flash_card_item', compact(['count', 'type', 'count_child']))->render(),
                'message' => '',
                'data' => $count_child
            ]);
        }
        if ($data['type'] == 'parent') {
            $count = (int)$data['count'] + 1;
            return response()->json([
                'error' => false,
                'template' => view('backend.lesson.question.flash_chuoi.flash_card_box', compact(['count']))->render(),
                'message' => '',
                'data' => $count
            ]);
        }


    }

    public function getTemplateDienTuDoanvan(Request $request)
    {
        $data = $request->all();
        $var = [];
        $count = (int)$data['count'] + 1;
        //$count_child = (int)$data['count_child'] + 1;        
        return response()->json([
            'error' => false,
            'template' => view('backend.lesson.question.dien_tu_doan_van.dien_tu_doan_van_box', compact(['count']))->render(),
            'message' => '',
            'data' => $count
        ]);
    }

    public function getTemplateDienTu(Request $request)
    {
        $data = $request->all();
        $var = [];
        $count = (int)$data['count'] + 1;
        //$count_child = (int)$data['count_child'] + 1;        
        return response()->json([
            'error' => false,
            'template' => view('backend.lesson.question.dien_tu.box_dien_tu', compact(['count']))->render(),
            'message' => '',
            'data' => $count
        ]);

    }

    public function getTemplateTracNghiem(Request $request)
    {
        $data = $request->all();
        $var = [];

        if ($data['type'] == 'answer') {
            $count = (int)$data['count'];
            $type = $data['type'];
            $templateType = $data['templateType'];
            $count_child = (int)$data['count_child'] + 1;
            return response()->json([
                'error' => false,
                'template' => view('backend.lesson.question.trac_nghiem.trac_nghiem_item', compact(['count', 'type', 'templateType', 'count_child']))->render(),
                'message' => '',
                'data' => []
            ]);
        }
        if ($data['type'] == 'parent') {
            $count = (int)$data['count'] + 1;
            return response()->json([
                'error' => false,
                'template' => view('backend.lesson.question.trac_nghiem.trac_nghiem_box', compact(['count']))->render(),
                'message' => '',
                'data' => $count
            ]);
        }


    }

    public function edit(Request $request)
    {
        $data = $request->all();
        if (!isset($data['id']) || empty($data['id'])) {
            alert()->error('Dữ liệu không tồn tại');
            return redirect()->route('dashboard');
            // return response()->json([
            //     'error'=>true,
            //     'msg'=>'Câu hỏi không tồn tại'
            // ]);
        }
        $question = Question::find($data['id']);
        if (!$question) {
            alert()->error('Dữ liệu không tồn tại');
            return redirect()->route('dashboard');
        }
        $course = Course::find($question->course_id);
        $var['breadcrumb'] = array(
            array(
                'url' => route('course.detail', ['id' => $question->course_id]),
                'title' => $course->name,
            ),
            array(
                'url' => '',
                'title' => 'Sửa câu hỏi',
            )
        );
        //$lesson = Lesson::find($question->lesson_id);
        if ($question->type == Question::TYPE_FLASH_SINGLE) {

        }
        if ($question->type == Question::TYPE_FLASH_MUTI) {
            $cardMutiles = QuestionCardMuti::where('parent_id', $data['id'])->where('lesson_id', $question->lesson_id)->orderBy('id', 'ASC')->get();

            foreach ($cardMutiles as $key => $card) {
                $card->child = QuestionCardMuti::where('parent_id', $card->id)->where('lesson_id', $question->lesson_id)->orderBy('id', 'ASC')->get();
            }
            $question->child_cards = $cardMutiles;
        }
        if ($question->type == Question::TYPE_DIEN_TU) {
            $question_childs = Question::where('parent_id', $data['id'])->orderBy('id', 'ASC')->get();
            foreach ($question_childs as $key => $question_child) {
                $question_child->answers = QuestionAnswer::where('question_id', $question_child->id)->first();
            }
            $question->childs = $question_childs;
        }
        if ($question->type == Question::TYPE_TRAC_NGHIEM) {
            $question_childs = Question::where('parent_id', $data['id'])->orderBy('id', 'ASC')->get();
            foreach ($question_childs as $key => $question_child) {
                $question_child->answers_errors = QuestionAnswer::where('question_id', $question_child->id)->where('status', QuestionAnswer::REPLY_ERROR)->get();
                $question_child->answer_ok = QuestionAnswer::where('question_id', $question_child->id)->where('status', QuestionAnswer::REPLY_OK)->first();
            }
            $question->childs = $question_childs;
        }
        if ($question->type == Question::TYPE_DIEN_TU_DOAN_VAN) {
            $question->childs = Question::where('parent_id', $data['id'])->orderBy('id', 'ASC')->get();

        }

        return view('backend.lesson.edit_question', compact('question', 'data', 'var'));
        //dd($question);
        return response()->json([
            'error' => false,
            'template' => view('backend.lesson.question.box_edit_question', compact(['question']))->render(),
            'message' => '',
            'data' => ''
        ]);
    }

    public function editSave(Request $request)
    {
        $data = $request->all();
        if (!Auth::check()) {
            alert()->error('Bạn cần đăng nhập để thực hiện hành động này');
            return redirect()->route('dashboard');
        }
        $user = Auth::user();
        if (!isset($data['id']) || empty($data['id'])) {
            alert()->error('Câu hỏi không tồn tại');
            return redirect()->route('dashboard');
        }
        $question = Question::find($data['id']);
        if ($question->type == Question::TYPE_FLASH_SINGLE) {

            $question->updated_at = time();
            $question->img_before = $data['img_card_before'];
            $question->img_after = $data['img_card_after'];
            $question->explain_before = Helper::detectMathLatex($data['explain']['before']);
            $question->explain_after = Helper::detectMathLatex($data['explain']['after']);
            $question->content = Helper::detectMathLatex($data['content']);
            $question->question = Helper::detectMathLatex($data['question_card']);

            if ($question->save()) {
                alert()->success('Cập nhật thành công');
            } else {
                alert()->error('Cập nhật không thành công');
            }

        }
        if ($question->type == Question::TYPE_FLASH_MUTI) {

            $question->updated_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->audio_content = $data['audio_content'];
            $question->img_before = $data['image'];

            if ($question->save()) {
                foreach ($data['card_question'] as $key => $q_sub) {
                    if (!empty($q_sub)) {
                        $question_sub = QuestionCardMuti::where('parent_id', $data['id'])->where('id', $key)->first();
                        if ($question_sub) {

                            $question_sub->question = $q_sub;
                            $question_sub->question_after = Helper::detectMathLatex($data['card_question_after'][$key]);
                            $question_sub->explain_before = Helper::detectMathLatex($data['card_explain'][$key]['before']);
                            $question_sub->explain_after = Helper::detectMathLatex($data['card_explain'][$key]['after']);
                            $question_sub->img_before = $data['card_img_before'][$key];
                            $question_sub->img_after = $data['card_img_after'][$key];
                            $question_sub->audio_question = $data['audio_card_question'][$key];
                            $question_sub->audio_question_after = $data['audio_card_question_after'][$key];

                            if ($question_sub->save()) {
                                if (isset($data['question_child']) && count($data['question_child']) > 0) {
                                    foreach ($data['question_child'] as $key_child => $q_childs) {
                                        if ($key_child == $key) {
                                            foreach ($q_childs as $key_child_2 => $q_child) {
                                                $question_sub_child = QuestionCardMuti::where('parent_id', $key)->where('id', $key_child_2)->first();
                                                if ($question_sub_child) {

                                                    $question_sub_child->question = Helper::detectMathLatex($q_child);
                                                    $question_sub_child->question_after = Helper::detectMathLatex($data['card_question_after_child'][$key][$key_child_2]);
                                                    $question_sub_child->explain_before = Helper::detectMathLatex($data['explain_before_child'][$key][$key_child_2]);
                                                    $question_sub_child->explain_after = Helper::detectMathLatex($data['explain_after_child'][$key][$key_child_2]);
                                                    $question_sub_child->img_before = $data['img_before_child'][$key][$key_child_2];
                                                    $question_sub_child->img_after = $data['img_after_child'][$key][$key_child_2];
                                                    $question_sub_child->audio_question = $data['audio_card_question_child'][$key][$key_child_2];
                                                    $question_sub_child->audio_question_after = $data['audio_card_question_after_child'][$key][$key_child_2];

                                                    $question_sub_child->save();
                                                } else {
                                                    // them moi
                                                    $question_sub_child = new QuestionCardMuti();
                                                    $question_sub_child->lesson_id = $data['lesson_id'];
                                                    $question_sub_child->user_id = $user->id;
                                                    $question_sub_child->question_id = $question->id;
                                                    $question_sub_child->parent_id = $question_sub->id;
                                                    $question_sub_child->question = Helper::detectMathLatex($q_child);
                                                    $question_sub_child->question_after = Helper::detectMathLatex($data['card_question_after_child'][$key][$key_child_2]);
                                                    $question_sub_child->explain_before = Helper::detectMathLatex($data['explain_before_child'][$key][$key_child_2]);
                                                    $question_sub_child->explain_after = Helper::detectMathLatex($data['explain_after_child'][$key][$key_child_2]);
                                                    $question_sub_child->img_before = $data['img_before_child'][$key][$key_child_2];
                                                    $question_sub_child->img_after = $data['img_after_child'][$key][$key_child_2];
                                                    $question_sub_child->audio_question = $data['audio_card_question_child'][$key][$key_child_2];
                                                    $question_sub_child->audio_question_after = $data['audio_card_question_after_child'][$key][$key_child_2];
                                                    $question_sub_child->save();
                                                }

                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            //them moi
                            $question_sub = new QuestionCardMuti();
                            $question_sub->lesson_id = $data['lesson_id'];
                            $question_sub->course_id = $question->course_id;
                            $question_sub->question_id = $question->id;
                            $question_sub->parent_id = $question->id;
                            $question_sub->question = Helper::detectMathLatex($q_sub);
                            $question_sub->question_after = Helper::detectMathLatex($data['card_question_after'][$key]);
                            $question_sub->explain_before = Helper::detectMathLatex($data['card_explain'][$key]['before']);
                            $question_sub->explain_after = Helper::detectMathLatex($data['card_explain'][$key]['after']);
                            $question_sub->img_before = $data['card_img_before'][$key];
                            $question_sub->img_after = $data['card_img_after'][$key];
                            $question_sub->audio_question = $data['audio_card_question'][$key];
                            $question_sub->audio_question_after = $data['audio_card_question_after'][$key];

                            $question_sub->save();
                            if (isset($data['question_child']) && count($data['question_child']) > 0) {
                                foreach ($data['question_child'] as $key_child => $q_childs) {
                                    if ($key_child == $key) {
                                        foreach ($q_childs as $key_child_2 => $q_child) {
                                            $question_sub_child = new QuestionCardMuti();
                                            $question_sub_child->lesson_id = $data['lesson_id'];
                                            $question_sub_child->course_id = $question->course_id;
                                            $question_sub_child->user_id = $user->id;
                                            $question_sub_child->question_id = $question->id;
                                            $question_sub_child->parent_id = $question_sub->id;
                                            $question_sub_child->question = Helper::detectMathLatex($q_child);
                                            $question_sub_child->question_after = Helper::detectMathLatex($data['card_question_after_child'][$key][$key_child_2]);
                                            $question_sub_child->explain_before = Helper::detectMathLatex($data['explain_before_child'][$key][$key_child_2]);
                                            $question_sub_child->explain_after = Helper::detectMathLatex($data['explain_after_child'][$key][$key_child_2]);
                                            $question_sub_child->img_before = $data['img_before_child'][$key][$key_child_2];
                                            $question_sub_child->img_after = $data['img_after_child'][$key][$key_child_2];
                                            $question_sub_child->audio_question = $data['audio_card_question_child'][$key][$key_child_2];
                                            $question_sub_child->audio_question_after = $data['audio_card_question_after_child'][$key][$key_child_2];
                                            $question_sub_child->save();
                                        }
                                    }
                                }
                            }
                        }

                    }
                }
                alert()->success('Cập nhật thành công');
            }
        }
        if ($question->type == Question::TYPE_DIEN_TU) {

            $question->updated_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->img_before = $data['image'];
            $question->interpret_all = Helper::detectMathLatex($data['interpret_dt_global']);
            $question->audio_content = $data['audio_content'];
            $question->save();
            foreach ($data['question'] as $key => $q) {
                $que = Question::where('id', $key)->where('parent_id', $data['id'])->first();
                if ($que) {
                    $que->updated_at = time();
                    $que->question = Helper::detectMathLatex($q);
                    $que->explain_before = Helper::detectMathLatex($data['explain'][$key]);
                    $que->interpret = Helper::detectMathLatex($data['interpret'][$key]);
                    $que->audio_question = $data['audio_question'][$key];
                    $que->img_before = $data['image_question'][$key];
                    if ($que->save()) {
                        $an = QuestionAnswer::where('question_id', $key)->first();
                        if ($an) {
                            $an->answer = Helper::detectMathLatex($data['answer'][$key]);
                            $an->image = $data['answer_dt_img'][$key];
                            //$an->create_at = time();
                            $an->save();
                        }
                    }
                } else {
                    //them moi
                    $que = new Question();
                    $que->type = $question->type;
                    $que->parent_id = $data['id'];
                    $que->lesson_id = $data['lesson_id'];
                    $que->course_id = $question->course_id;
                    $que->user_id = $user->id;
                    $que->created_at = time();
                    $que->question = Helper::detectMathLatex($q);
                    $que->explain_before = Helper::detectMathLatex($data['explain'][$key]);
                    $que->audio_question = $data['audio_question'][$key];
                    $que->img_before = $data['image_question'][$key];
                    //$que->explain_after = '';
                    if ($que->save()) {
                        $an = new QuestionAnswer();
                        $an->user_id = $user->id;
                        $an->question_id = $que->id;
                        $an->answer = Helper::detectMathLatex($data['answer'][$key]);
                        $an->status = QuestionAnswer::REPLY_OK;
                        $an->image = $data['answer_dt_img'][$key];
                        $an->create_at = time();
                        $an->save();
                    }
                }
                alert()->success('Cập nhật thành công');
            }
        }
        if ($question->type == Question::TYPE_TRAC_NGHIEM) {
            //dd($data);
            $list_answer = [];

            $question->updated_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->explain_before = Helper::detectMathLatex($data['explain_tn_global']);
            $question->interpret_all = Helper::detectMathLatex($data['interpret_tn_global']);
            $question->img_before = $data['image'];
            $question->audio_content = $data['audio_content'];
            $question->save();
            if (isset($data['question_tn']) && count($data['question_tn']) > 0) {
                foreach ($data['question_tn'] as $key => $value) {
                    if (!empty($value)) {
                        $question_sub = Question::where('parent_id', $question->id)->where('id', $key)->first();
                        if ($question_sub) {
                            $question_sub->updated_at = time();
                            $question_sub->question = Helper::detectMathLatex($value);
                            $question_sub->img_before = $data['question_img'][$key];
                            $question_sub->explain_before = Helper::detectMathLatex($data['explain_tn'][$key]);
                            $question_sub->interpret = Helper::detectMathLatex($data['interpret_tn'][$key]);
                            $question_sub->audio_question = $data['audio_question_tn'][$key];
                            $question_sub->save();

                            $as_right = QuestionAnswer::where('question_id', $question_sub->id)->where('status', QuestionAnswer::REPLY_OK)->first();
                            if ($as_right) {
                                $as_right->answer = Helper::detectMathLatex($data['answer_tn'][$key]);
                                //$as_right->status = QuestionAnswer::REPLY_OK;
                                $as_right->image = $data['answer_img'][$key];
                                //$as_right->create_at = time();
                                $as_right->save();
                                $list_answer[] = $as_right->id;
                            } else {
                                $as_right = new QuestionAnswer();
                                $as_right->user_id = $user->id;
                                $as_right->question_id = $question_sub->id;
                                $as_right->answer = Helper::detectMathLatex($data['answer_tn'][$key]);
                                $as_right->status = QuestionAnswer::REPLY_OK;
                                $as_right->image = $data['answer_img'][$key];
                                $as_right->create_at = time();
                                $as_right->save();
                                $list_answer[] = $as_right->id;
                            }
                            if (isset($data['answer_error_tn']) && count($data['answer_error_tn']) > 0) {
                                foreach ($data['answer_error_tn'] as $key_as_error => $ans_er_value) {
                                    if ($key_as_error == $key) {
                                        foreach ($ans_er_value as $key_item => $ans_er_value_item) {
                                            if (!empty($ans_er_value_item)) {
                                                $as_err = QuestionAnswer::where('question_id', $question_sub->id)->where('id', $key_item)->first();
                                                if ($as_err) {
                                                    $as_err->answer = Helper::detectMathLatex($ans_er_value_item);
                                                    $as_err->status = QuestionAnswer::REPLY_ERROR;
                                                    $as_err->image = $data['answer_img_error'][$key][$key_item];
                                                    $as_err->create_at = time();
                                                    $as_err->save();
                                                    //luu vao de sau xoa
                                                    $list_answer[] = $as_err->id;
                                                } else {
                                                    // them moi
                                                    $as_err = new QuestionAnswer();
                                                    $as_err->user_id = $user->id;
                                                    $as_err->question_id = $question_sub->id;
                                                    $as_err->answer = Helper::detectMathLatex($ans_er_value_item);
                                                    $as_err->status = QuestionAnswer::REPLY_ERROR;
                                                    $as_err->image = $data['answer_img_error'][$key][$key_item];
                                                    $as_err->create_at = time();
                                                    $as_err->save();
                                                    //luu vao de sau xoa
                                                    $list_answer[] = $as_err->id;
                                                }
                                            }

                                        }

                                    }
                                }
                            }
                            // xoa het cac cau tra loi duoc xoa bo
                            if (count($list_answer) > 0) {
                                $answersdeletes = QuestionAnswer::whereNotIn('id', $list_answer)->where('question_id', $question_sub->id)->get();
                                if (count($answersdeletes) > 0) {
                                    foreach ($answersdeletes as $answersdelete) {
                                        if (!in_array($answersdelete->id, $list_answer)) {
                                            $answersdelete->delete();
                                        }
                                    }
                                }

                            }

                        } else {
                            //them moi cau hoi
                            $question_sub = new Question();
                            $question_sub->type = $question->type;
                            $question_sub->parent_id = $question->id;
                            $question_sub->lesson_id = $data['lesson_id'];
                            $question_sub->course_id = $question->course_id;
                            $question_sub->user_id = $user->id;
                            $question_sub->created_at = time();
                            $question_sub->question = Helper::detectMathLatex($value);
                            $question_sub->explain_before = Helper::detectMathLatex($data['explain_tn'][$key]);
                            $question_sub->img_before = $data['question_img'][$key];
                            $question_sub->audio_question = $data['audio_question_tn'][$key];
                            $question_sub->save();

                            // cau tra lơi dung
                            $as_right = new QuestionAnswer();
                            $as_right->user_id = $user->id;
                            $as_right->question_id = $question_sub->id;
                            $as_right->answer = Helper::detectMathLatex($data['answer_tn'][$key]);
                            $as_right->status = QuestionAnswer::REPLY_OK;
                            $as_right->image = $data['answer_img'][$key];
                            $as_right->create_at = time();
                            $as_right->save();

                            if (isset($data['answer_error_tn']) && count($data['answer_error_tn']) > 0) {


                                foreach ($data['answer_error_tn'] as $key_as_error => $ans_er_value) {
                                    if ($key_as_error == $key) {
                                        foreach ($ans_er_value as $key_item => $ans_er_value_item) {
                                            if (!empty($ans_er_value_item)) {
                                                $as_err = new QuestionAnswer();
                                                $as_err->user_id = $user->id;
                                                $as_err->question_id = $question_sub->id;
                                                $as_err->answer = Helper::detectMathLatex($ans_er_value_item);
                                                $as_err->status = QuestionAnswer::REPLY_ERROR;
                                                $as_err->image = $data['answer_img_error'][$key][$key_item];
                                                $as_err->create_at = time();
                                                $as_err->save();
                                                //luu vao de sau xoa
                                                //$list_answer[] = $as_err->id;
                                            }

                                        }
                                    }
                                }


                            }
                        }

                    }

                }
            }
            alert()->success('Cập nhật thành công');
        }
        if ($question->type == Question::TYPE_DIEN_TU_DOAN_VAN) {

            $question->updated_at = time();
            $question->content = Helper::detectMathLatex($data['content']);
            $question->interpret_all = Helper::detectMathLatex($data['interpret_dv_global']);
            $question->img_before = $data['image'];
            $question->save();
            foreach ($data['question_dt'] as $key => $q) {
                $que = Question::where('id', $key)->where('parent_id', $data['id'])->first();
                if ($que) {
                    $que->updated_at = time();
                    $que->question = Helper::detectMathLatex($q);
                    $que->explain_before = Helper::detectMathLatex($data['explanation'][$key]);
                    $que->interpret = Helper::detectMathLatex($data['interpret_dv'][$key]);
                    $que->save();
                } else {
                    //them moi
                    $que = new Question();
                    $que->type = $question->type;
                    $que->parent_id = $question->id;
                    $que->lesson_id = $data['lesson_id'];
                    $que->course_id = $question->course_id;
                    $que->user_id = $user->id;
                    $que->created_at = time();
                    $que->question = Helper::detectMathLatex($q);
                    $que->explain_before = Helper::detectMathLatex($data['explanation'][$key]);
                    $que->interpret = Helper::detectMathLatex($data['interpret_dv'][$key]);
                    $que->save();
                }
                alert()->success('Cập nhật thành công');
            }
        }
        if (isset($data['feedback_id'])) {
            Feedback::where('id', $data['feedback_id'])->update(['status' => Feedback::STATUS_EDIT, 'update_date' => time()]);
            return redirect()->route('course.detail', ['id' => $question->course_id, 'type' => 'feedback']);
        }
        return redirect()->route('lesson.detail', ['id' => $question->lesson_id]);

    }

    public function delete(Request $request)
    {
        $data = $request->all();
        if (!isset($data['id'])) {
            return response()->json([
                'error' => true,
                'msg' => 'Câu hỏi không tồn tại'
            ]);
        }
        $question = Question::find($data['id']);
        if (!$question) {
            return response()->json([
                'error' => true,
                'msg' => 'Câu hỏi không tồn tại'
            ]);
        }
        $parent_id = $question->parent_id;
        $lesson_id = $question->lesson_id;

        if ($question->delete()) {
            if ($parent_id == 0) {
                return response()->json([
                    'error' => false,
                    'msg' => 'Xoá dữ liệu thành công',
                    'redirect' => route('lesson.detail', ['id' => $lesson_id])
                ]);
            } else {
                return response()->json([
                    'error' => false,
                    'msg' => 'Xoá dữ liệu thành công',
                    //'redirect'=> route('lesson.detail',['id'=>$lesson_id])
                ]);
            }

        } else {
            return response()->json([
                'error' => true,
                'msg' => 'Xoá dữ liệu không thành công'
            ]);
        }
        // if($data['question_type'] == Question::TYPE_DIEN_TU)
        // {

        // }
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');
        //dd($request->all());
        if ($file) {
            $path = '/images/exercise/';
            $destinationPath = public_path($path);
            $fileName = str_replace('.' . $file->getClientOriginalExtension(), '', $file->getClientOriginalName()) . time() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $fileName);
            return response()->json(['status' => 1, 'name' => $fileName, 'image' => asset('public/' . $path . '' . $fileName), 'url' => $path . '' . $fileName]);
        }
    }

    public function order($id)
    {
        $lesson = Lesson::find($id);
        if (!$lesson) {
            alert()->error('Có lỗi', 'Bài học không tồn tại');
            return redirect()->route('dashboard');
        }
        $questions = Question::where('lesson_id', $id)
            ->where('parent_id', 0)
            ->orderBy('order_s', 'ASC')
            ->orderBy('id', 'ASC')->get();
        $var['lesson'] = $lesson;
        $var['questions'] = $questions;
        $var['breadcrumb'] = array(
            array(
                'url' => route('lesson.detail', ['id' => $id]),
                'title' => $lesson->name,
            )
        );
        return view('backend.question.question_order', compact('var'));
    }

    public function orderSave(Request $request)
    {
        $data = $request->all();
        if ($data['order'] != '') {
            $question_order = json_decode($data['order']);
            foreach ($question_order as $key => $order) {
                $question = Question::find($order->id);
                if ($question) {
                    $question->order_s = $key;
                    $question->save();
                }
            }
        }
        return response()->json(array('error' => false, 'msg' => 'Cập nhật thành công'));
    }
}
