<?php

namespace App\Imports;

use App\Exceptions\BadRequestException;
use App\Models\ExamQuestion;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionCardMuti;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class QuestionImport implements ToCollection
{
    protected $data;
    protected $flash_chuoi  = [];
    protected $dien_tu_ngan = [];
    protected $trac_nghiem  = [];
    protected $dien_tu_doan_van = [];
    protected $is_exam      = false;


    public function __construct($data)
    {
        $this->data = $data;

    }

    /**
     * @param Collection $collection
     * @return \Illuminate\Http\JsonResponse|Collection
     * @throws \Exception
     */
    public function collection(Collection $collection)
    {
        DB::beginTransaction();
        try {
            foreach ($collection as $keys => $value) {
            if ($keys >= 1) {
                $items = array_filter($value->toArray());

                if (isset($items[0])) {

                    // Câu hỏi cho flashcard
                    if (strpos($items[0], '#f.') !== false) {

                        $this->insertQuestion();

                        // cau hoi flash don
                        $formatData = $this->_formatFlashCard($items);
                        $item_flash = array(
                            'content'        => $formatData['content'],
                            'type'           => Question::TYPE_FLASH_SINGLE,
                            'parent_id'      => 0,
                            'lesson_id'      => $this->data['lesson_id'],
                            'course_id'      => $this->data['course_id'],
                            'user_id'        => $this->data['user_id'],
                            'created_at'     => time(),
                            'explain_before' => $formatData['explain_before'],
                            'explain_after'  => $formatData['explain_after'],
                            'question'       => $formatData['question_before'],
                            'question_after' => $formatData['question_after'],
                            'img_before'     => $formatData['img_before'],
                            'img_after'      => $formatData['img_after']
                        );
                        Question::insert($item_flash);
                    }

                    // Câu hỏi cho multi flashcard
                    if (strpos($items[0], '#mf.') !== false) {

                        $this->insertQuestion();

                        // cau hoi flash chuoi
                        if (strpos($items[0], '#mf.') !== false) {
                            $this->flash_chuoi['content']    = $this->_detectMathLatex(str_replace('#mf.', '', $items[0]));
                            $this->flash_chuoi['user_id']    = $this->data['user_id'];
                            $this->flash_chuoi['lesson_id']  = $this->data['lesson_id'];
                            $this->flash_chuoi['course_id']  = $this->data['course_id'];
                            $this->flash_chuoi['created_at'] = time();
                        }
                    }
//
                    // dien tu ngan
                    if (strpos($items[0], '#q.') !== false) {

                        $this->insertQuestion();

                        // bat dau dien tu ngan
                        // doan van dien tu ngan
                        $formatData                = $this->_formatDienTu($items);
                        $this->dien_tu_ngan['content']   = $this->_detectMathLatex(str_replace('#q.', '', $items[0]));
                        $this->dien_tu_ngan['interpret'] = $this->_detectMathLatex($formatData['interpret']);

                        $this->dien_tu_ngan['user_id']   = $this->data['user_id'];
                        $this->dien_tu_ngan['lesson_id'] = $this->data['lesson_id'];
                        $this->dien_tu_ngan['course_id'] = $this->data['course_id'];
                        $this->dien_tu_ngan['image']     = $formatData['image'];
                    }


                    // trac nghiem
                    if (strpos($items[0], '#tn.') !== false) {
                        $this->insertQuestion();

                        // bat dau trac nghiem
                        // doan van trac nghiem
                        $formatData = $this->_formatTracNghiem($items);

                        $this->trac_nghiem['content']        = $this->_detectMathLatex(str_replace('#tn.', '', $items[0]));
                        $this->trac_nghiem['user_id']        = $this->data['user_id'];
                        $this->trac_nghiem['explain_before'] = $formatData['explain_before'];
                        $this->trac_nghiem['interpret']      = $formatData['interpret'];
                        $this->trac_nghiem['lesson_id']      = $this->data['lesson_id'];
                        $this->trac_nghiem['course_id']      = $this->data['course_id'];
                        $this->trac_nghiem['image']          = $formatData['image'];
                    }

                    if (strpos($items[0], '$f.') !== false) {
                        $formatData = $this->_formatFlashCard($items);
                        // cau hoi flash chuoi cha
                        $this->flash_chuoi['childs'][] = array(
                            'explain_before' => $formatData['explain_before'],
                            'explain_after'  => $formatData['explain_after'],
                            'course_id'      => $this->data['course_id'],
                            'question'       => $formatData['question_before'],
                            'question_after' => $formatData['question_after'],
                            'img_before'     => $formatData['img_before'],
                            'img_after'      => $formatData['img_after']
                        );
                    }

                    if (strpos($items[0], '$sf.') !== false) {
                        // cau hoi flash chuoi con
                        //get flash card cha cuoi cung
                        $last_parent = count($this->flash_chuoi['childs']);
                        if ($last_parent > 0) {
                            $formatData                                          = $this->_formatFlashCard($items);
                            $this->flash_chuoi['childs'][$last_parent - 1]['childs'][] = array(
                                'explain_before' => $formatData['explain_before'],
                                'explain_after'  => $formatData['explain_after'],
                                'course_id'      => $this->data['course_id'],
                                'question'       => $this->_detectMathLatex(str_replace('$sf.', '', $items[0])),
                                'question_after' => $formatData['question_after'],
                                'img_before'     => $formatData['img_before'],
                                'img_after'      => $formatData['img_after']
                            );

                        }
                    }

                    if (strpos($items[0], '$d.') !== false) {
                        //cau hoi dien tu ngan
                        $formatData               = $this->_formatDienTu($items);
                        $this->dien_tu_ngan['childs'][] = array(
                            'question'       => $this->_detectMathLatex($formatData['question']),
                            'explain_before' => $this->_detectMathLatex($formatData['explain_before']),
                            'interpret'      => $this->_detectMathLatex($formatData['interpret']),
                            'image'          => $formatData['image'],
                            'answer'         => $formatData['answer'],
                            'course_id'      => $this->data['course_id'],
                        );
                    }

                    if (strpos($items[0], '$tn.') !== false) {
                        //cau hoi trac nghiem
                        $formatData = $this->_formatTracNghiem($items);

                        $this->trac_nghiem['childs'][] = array(
                            'question'       => $formatData['question'],
                            'explain_before' => $formatData['explain_before'],
                            'lesson_id'      => $this->data['lesson_id'],
                            'answer'         => $formatData['answer'],
                            'answer_error'   => $formatData['ansewr_error'],
                            'course_id'      => $this->data['course_id'],
                            'image'          => $formatData['image'],
                            'interpret'      => $formatData['interpret'],
                        );
                    }
                }
                //   dien tu doan van
                if (strpos($items[0], '#dt.') !== false) {
                    $this->insertQuestion();

                    // bat dau dien tu doan van
                    // doan van dien tu
                    $formatData                               = $this->_formatDienTuDoanVan($items);
                    $this->dien_tu_doan_van['content']        = $this->_detectMathLatex(str_replace('#dt.', '', $items[0]));
                    $this->dien_tu_doan_van['interpret']      = $this->_detectMathLatex($formatData['interpret']);
                    $this->dien_tu_doan_van['user_id']        = $this->data['user_id'];
                    $this->dien_tu_doan_van['explain_before'] = $formatData['explain_before'];
                    $this->dien_tu_doan_van['image']          = $formatData['image'];
                    $this->dien_tu_doan_van['lesson_id']      = $this->data['lesson_id'];
                    $this->dien_tu_doan_van['course_id']      = $this->data['course_id'];
                }

                if (strpos($items[0], '$dt.') !== false) {
                    //cau hoi dien tu doan van
                    $formatData                   = $this->_formatDienTuDoanVan($items);
                    $this->dien_tu_doan_van['childs'][] = array(
                        'question'       => $formatData['question'],
                        'explain_before' => $formatData['explain_before'],
                        'course_id'      => $this->data['course_id'],
                        'interpret'      => $this->_detectMathLatex($formatData['interpret']),
                    );
                }

                if ($keys == count($items) - 1) {
                    // duyet het dong cuoi cung.
                    $this->insertQuestion();
                }
                DB::commit();
            }
        }
        } catch
        (\Exception $e) {
            //die("111");
            DB::rollBack();

            throw new BadRequestException('Thêm câu hỏi không thành công!');
        }
        return response()->json(array('error' => true, 'msg' => 'Thêm dữ liệu thành công!'));
    }

    protected function _formatDienTuDoanVan($items)
    {
        $question = '';

        $explain_before = '';
        $image          = '';
        $interpret      = '';
        foreach ($items as $key => $text) {
            if (strpos($text, '$dt.') !== false) {
                $question = str_replace('$dt.', '', $text);
                $pattern  = '/<#(.*?)#>/';
                $content  = preg_replace_callback($pattern, function ($m) {
                    //return $m[1];
                    $path = explode('|', $m[1]);
                    if (isset($path[1])) {
                        return '<a class="clozetip" title="' . $path[1] . '" href="#">' . $path[0] . '</a>';
                    } else {
                        return '<a class="clozetip" title="" href="#">' . $path[0] . '</a>';
                    }
                }, $question);

                $question = $content;
            }
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.', '', $text);
                $explain_before = $this->_detectMathLatex($explain_before);
            }
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.', '', $text);
            }
            if (strpos($text, '$e.') !== false) {
                $interpret = str_replace('$e.', '', $text);
                $interpret = $this->_detectMathLatex($interpret);
            }
        }

        return array(
            'question'       => $this->_detectMathLatex($question, 'doan_van'),
            'image'          => $image,
            'explain_before' => $explain_before,
            'interpret'      => $interpret
        );
    }

    protected function _formatDienTu($items)
    {
        $question       = '';
        $ansewr         = '';
        $explain_before = '';
        $image          = '';
        $interpret      = '';

        foreach ($items as $key => $text) {
            if (strpos($text, '$d.') !== false) {
                $question = str_replace('$d.', '', $text);
                $question = $this->_detectMathLatex($question);
            }
            if (strpos($text, '$t.') !== false) {
                $ansewr = str_replace('$t.', '', $text);
                $ansewr = $this->_detectMathLatex($ansewr);
            }
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.', '', $text);
                $explain_before = $this->_detectMathLatex($explain_before);
            }
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.', '', $text);
            }
            if (strpos($text, '$e.') !== false) {
                $interpret = str_replace('$e.', '', $text);
                $interpret = $this->_detectMathLatex($interpret);
            }
        }
        return array(
            'question'       => $question,
            'answer'         => $ansewr,
            'explain_before' => $explain_before,
            'image'          => $image,
            'interpret'      => $interpret
        );
    }

    protected function _formatTracNghiem($items)
    {
        $question       = '';
        $ansewr         = '';
        $ansewr_error   = [];
        $explain_before = '';
        $image          = '';
        $interpret      = '';

        foreach ($items as $key => $text) {
            if (strpos($text, '$tn.') !== false) {
                $question = str_replace('$tn.', '', $text);

                $question = $this->_detectMathLatex($question);
            }
            if (strpos($text, '$t.') !== false) {
                $ansewr = str_replace('$t.', '', $text);
                $ansewr = $this->_detectMathLatex($ansewr);
            }
            if (strpos($text, '$h.') !== false) {
                $explain_before = str_replace('$h.', '', $text);
                $explain_before = $this->_detectMathLatex($explain_before);
            }
            if (strpos($text, '$s.') !== false) {

                $text_temp      = str_replace('$s.', '', $text);
                $ansewr_error[] = $this->_detectMathLatex($text_temp);
            }
            if (strpos($text, '$i.') !== false) {
                $image = str_replace('$i.', '', $text);
            }
            if (strpos($text, '$e.') !== false) {
                $interpret = str_replace('$e.', '', $text);
                $interpret = $this->_detectMathLatex($interpret);
            }
        }
        return array(
            'question'       => $question,
            'answer'         => $ansewr,
            'explain_before' => $explain_before,
            'ansewr_error'   => $ansewr_error,
            'image'          => $image,
            'interpret'      => $interpret
        );
    }

    protected function _formatFlashCard($items)
    {
        $content         = '';
        $question_after  = '';
        $question_before = '';
        $explain_after   = '';
        $explain_before  = '';
        $img_before      = '';
        $img_after       = '';
        foreach ($items as $key => $text) {
            if (strpos($text, '#f.') !== false) {
                $content = str_replace('#f.', '', $text);
                $content = $this->_detectMathLatex($content);
            }
            if (strpos($text, '$b.') !== false) {
                $question_after = str_replace('$b.', '', $text);
                $question_after = $this->_detectMathLatex($question_after);
            }
            if (strpos($text, '$f.') !== false) {
                $question_before = str_replace('$f.', '', $text);
                $question_before = $this->_detectMathLatex($question_before);
            }
            if (strpos($text, '$bh.') !== false) {
                $explain_after = str_replace('$bh.', '', $text);
                $explain_after = $this->_detectMathLatex($explain_after);
            }
            if (strpos($text, '$fh.') !== false) {
                $explain_before = str_replace('$fh.', '', $text);
                $explain_before = $this->_detectMathLatex($explain_before);
            }
            if (strpos($text, '$fi.') !== false) {
                $img_before = str_replace('$fi.', '', $text);
            }
            if (strpos($text, '$bi.') !== false) {
                $img_after = str_replace('$bi.', '', $text);
            }
        }
        return array(
            'content'         => $content,
            'question_after'  => $question_after,
            'question_before' => $question_before,
            'explain_after'   => $explain_after,
            'explain_before'  => $explain_before,
            'img_after'       => $img_after,
            'img_before'      => $img_before,
        );
    }

    protected function _saveTracNghiem($items, $lesson_id = 0)
    {
        //dd($items);

        $lessonId = !isset($items['lesson_id']) ? $items['lesson_id'] : $lesson_id;
        $question                 = new Question();
        $question->type           = Question::TYPE_TRAC_NGHIEM;
        $question->parent_id      = 0;
        $question->lesson_id      = $lessonId;
        $question->course_id      = $items['course_id'];
        $question->user_id        = $items['user_id'];
        $question->created_at     = time();
        $question->content        = $items['content'];
        $question->explain_before = $items['explain_before'];
        $question->interpret_all  = $items['interpret'];
        $question->img_before     = $items['image'];
        $question->save();

        $this->insertExamQuestion($lessonId, $question->id);

        if (isset($items['childs']) && count($items['childs']) > 0) {
            foreach ($items['childs'] as $key => $value) {
                if (!empty($value['question'])) {
                    $question_sub                 = new Question();
                    $question_sub->type           = Question::TYPE_TRAC_NGHIEM;
                    $question_sub->parent_id      = $question->id;
                    $question_sub->lesson_id      = !isset($items['lesson_id']) ? $items['lesson_id'] : $lesson_id;
                    $question_sub->course_id      = $value['course_id'];
                    $question_sub->user_id        = $items['user_id'];
                    $question_sub->created_at     = time();
                    $question_sub->question       = $value['question'];
                    $question_sub->explain_before = $value['explain_before'];
                    $question_sub->interpret      = $value['interpret'];
                    $question_sub->img_before     = $value['image'];
                    $question_sub->save();
                    if (isset($value['answer_error']) && count($value['answer_error']) > 0) {
                        foreach ($value['answer_error'] as $key_as_error => $ans_er_value) {
                            $as_err              = new QuestionAnswer();
                            $as_err->user_id     = $items['user_id'];
                            $as_err->question_id = $question_sub->id;
                            $as_err->answer      = $ans_er_value;
                            $as_err->status      = QuestionAnswer::REPLY_ERROR;
                            $as_err->image       = '';
                            $as_err->create_at   = time();
                            $as_err->save();
                        }
                        // cau tra lơi dung
                        $as_right              = new QuestionAnswer();
                        $as_right->user_id     = $items['user_id'];
                        $as_right->question_id = $question_sub->id;
                        $as_right->answer      = $value['answer'];
                        $as_right->status      = QuestionAnswer::REPLY_OK;
                        $as_right->image       = '';
                        $as_right->create_at   = time();
                        $as_right->save();
                    }
                }
            }
        }
    }

    protected function _saveDienTuDoanVan($items)
    {
        $question                = new Question();
        $question->type          = Question::TYPE_DIEN_TU_DOAN_VAN;
        $question->parent_id     = 0;
        $question->lesson_id     = $items['lesson_id'];
        $question->course_id     = $items['course_id'];
        $question->user_id       = $items['user_id'];
        $question->created_at    = time();
        $question->content       = $items['content'];
        $question->interpret_all = $items['interpret'];
        $question->img_before    = $items['image'];
        $question->save();

        $this->insertExamQuestion($items['lesson_id'], $question->id);

        if (isset($items['childs'])) {
            foreach ($items['childs'] as $key => $q) {
                $que                 = new Question();
                $que->type           = Question::TYPE_DIEN_TU_DOAN_VAN;
                $que->parent_id      = $question->id;
                $que->lesson_id      = $items['lesson_id'];
                $que->course_id      = $items['course_id'];
                $que->user_id        = $items['user_id'];
                $que->created_at     = time();
                $que->question       = $q['question'];
                $que->explain_before = $q['explain_before'];
                $que->interpret      = $q['interpret'];
                $que->save();
            }
        }
    }

    protected function _saveDienTu($items)
    {
        $question                = new Question();
        $question->type          = Question::TYPE_DIEN_TU;
        $question->parent_id     = 0;
        $question->lesson_id     = $items['lesson_id'];
        $question->course_id     = $items['course_id'];
        $question->user_id       = $items['user_id'];
        $question->created_at    = time();
        $question->content       = $items['content'];
        $question->interpret_all = $items['interpret'];
        $question->img_before    = $items['image'];
        $question->save();

        $this->insertExamQuestion($items['lesson_id'], $question->id);

        if (isset($items['childs'])) {
            foreach ($items['childs'] as $key => $q) {
                $que                 = new Question();
                $que->type           = Question::TYPE_DIEN_TU;
                $que->parent_id      = $question->id;
                $que->lesson_id      = $items['lesson_id'];
                $que->course_id      = $items['course_id'];
                $que->user_id        = $items['user_id'];
                $que->created_at     = time();
                $que->question       = $q['question'];
                $que->explain_before = $q['explain_before'];
                $que->interpret      = $q['interpret'];
                $que->img_before     = $q['image'];
                //$que->explain_after = '';
                if ($que->save()) {
                    $an              = new QuestionAnswer();
                    $an->user_id     = $items['user_id'];
                    $an->question_id = $que->id;
                    $an->answer      = $q['answer'];
                    $an->status      = QuestionAnswer::REPLY_OK;
                    $an->image       = '';
                    $an->create_at   = time();
                    $an->save();
                }
            }
        }

    }

    protected function _saveFlashChuoi($items)
    {
        $question             = new Question();
        $question->type       = Question::TYPE_FLASH_MUTI;
        $question->parent_id  = 0;
        $question->lesson_id  = $items['lesson_id'];
        $question->course_id  = $items['course_id'];
        $question->user_id    = $items['user_id'];
        $question->created_at = time();
        $question->content    = $items['content'];
        if ($question->save()) {
            if (isset($items['childs'])) {
                foreach ($items['childs'] as $key => $value) {
                    if (!empty($value['question'])) {
                        $question_sub                 = new QuestionCardMuti();
                        $question_sub->lesson_id      = $items['lesson_id'];
                        $question_sub->course_id      = $items['course_id'];
                        $question_sub->user_id        = $items['user_id'];
                        $question_sub->question_id    = $question->id;
                        $question_sub->parent_id      = $question->id;
                        $question_sub->question       = $value['question'];
                        $question_sub->question_after = $value['question_after'];
                        $question_sub->explain_before = $value['explain_before'];
                        $question_sub->explain_after  = $value['explain_after'];
                        $question_sub->img_before     = $value['img_before'];
                        $question_sub->img_after      = $value['img_after'];
                        $question_sub->create_at      = time();
                        $question_sub->save();
                        if (isset($value['childs']) && count($value['childs']) > 0) {
                            foreach ($value['childs'] as $key_child => $value_child) {
                                $question_sub_child                 = new QuestionCardMuti();
                                $question_sub_child->lesson_id      = $items['lesson_id'];
                                $question_sub_child->course_id      = $items['course_id'];
                                $question_sub_child->user_id        = $items['user_id'];
                                $question_sub_child->question_id    = $question->id;
                                $question_sub_child->parent_id      = $question_sub->id;
                                $question_sub_child->question       = $value_child['question'];
                                $question_sub_child->question_after = $value_child['question_after'];
                                $question_sub_child->explain_before = $value_child['explain_before'];
                                $question_sub_child->explain_after  = $value_child['explain_after'];
                                $question_sub_child->img_before     = $value_child['img_before'];
                                $question_sub_child->img_after      = $value_child['img_after'];
                                $question_sub_child->create_at      = time();
                                $question_sub_child->save();
                            }
                        }
                    }
                }
            }
        }

    }

    protected function _detectMathLatex($text, $type = '')
    {
        if ($type == 'doan_van') {
            if (strpos($text, '$') !== false) {
                $pattern = '/\\$(.*?)\\$/';
                $content = preg_replace_callback($pattern, function ($m) {
                    return "<span class='math-tex'>\($m[1]\)</span>";
                }, $text);
                $text    = $content;
            }
        } else {
            if (strpos($text, '$') !== false) {
                $pattern = '/\\$(.*?)\\$/';
                $content = preg_replace_callback($pattern, function ($m) {
                    return '<span class="math-tex">\(' . $m[1] . '\)</span>';
                }, $text);
                $text    = $content;
            }
        }
        return $text;
    }

    protected function insertQuestion(){

        //kiem tra xem flash chuoi da co chua . neu co roi thi luu data
        if (count($this->flash_chuoi) > 0) {
            $this->_saveFlashChuoi($this->flash_chuoi);
            $this->flash_chuoi = [];
        }

        //kiem tra xem dien tu ngan da co chua . neu co roi thi luu data
        if (count($this->dien_tu_ngan) > 0) {
            $this->_saveDienTu($this->dien_tu_ngan);
            $this->dien_tu_ngan = [];
        }

        //kiem tra xem trac nghiem da co chua . neu co roi thi luu data
        if (count($this->trac_nghiem) > 0) {
            $this->_saveTracNghiem($this->trac_nghiem, $this->data['lesson_id']);
            $this->trac_nghiem = [];
        }

        //kiem tra xem dien tu doan van co du lieu chua. neu co roi thi luu data
        if (count($this->dien_tu_doan_van) > 0) {
            $this->_saveDienTuDoanVan($this->dien_tu_doan_van);
            $this->dien_tu_doan_van = [];
        }
    }

    protected function insertExamQuestion($lesson_id, $question_id){
        if ($this->data['is_exam'] && $this->data['part']){
            ExamQuestion::create([
             'lesson_id' => $lesson_id,
             'question_id' => $question_id,
             'part' => $this->data['part'],
         ]);
        }
    }
}
