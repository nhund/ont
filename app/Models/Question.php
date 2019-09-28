<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\QuestionAnswer;
use App\Models\UserQuestionLog;
use App\Models\QuestionCardMuti;
use App\Models\QuestionLogCurrent;

class Question extends Model
{
    const STATUS_ON     = 1;
    const STATUS_OFF    = 2;

    const TYPE_FLASH_SINGLE = 1;
    const TYPE_FLASH_MUTI = 2;
    const TYPE_DIEN_TU = 3;
    const TYPE_TRAC_NGHIEM = 4;
    const TYPE_DIEN_TU_DOAN_VAN = 5;

    const TYPE  = [
        self::TYPE_FLASH_SINGLE => 'FlashCard đơn',
        self::TYPE_FLASH_MUTI => 'FlashCard chuỗi',
        self::TYPE_DIEN_TU => 'Điền từ',
        self::TYPE_TRAC_NGHIEM => 'Trắc nghiệm',
        self::TYPE_DIEN_TU_DOAN_VAN => 'Điền từ đoạn văn',
    ];

    const REPLY_ERROR = 1;
    const REPLY_OK = 2;

    const LEARN_LAM_BAI_MOI = 'lam-bai-moi';
    const LEARN_LAM_CAU_CU = 'lam-cau-cu';
    const LEARN_LAM_CAU_SAI = 'lam-cau-sai';
    const LEARN_LAM_BOOKMARK = 'lam-bookmark';
    const LEARN_LAM_BAI_TAP = 'lam-bai-tap';

    protected $table = 'question';
    protected $primaryKey = 'id';

    protected $fillable = [
    ];
    public $timestamps = false;

    public function answer() {
        return $this->hasMany('App\Models\QuestionAnswer', 'question_id', 'id');
    }
    public function lesson() {
        return $this->hasOne('App\Models\Lesson', 'id', 'lesson_id');
    }
    public static function boot()
    {
        parent::boot();


        self::creating(function($model){

        });
        self::created(function($model){
            
        });

        self::updating(function($model){

        });

        self::updated(function($model){

        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            if (isset($model->attributes['id']))
            {
                if($model->attributes['type'] == self::TYPE_DIEN_TU || $model->attributes['type'] == self::TYPE_TRAC_NGHIEM)
                {
                    if($model->attributes['parent_id'] == 0)
                    {
                        $question_childs = Question::where('parent_id',$model->attributes['id'])->get()->pluck('id')->toArray();
                        //xoa cau hoi
                        Question::where('parent_id',$model->attributes['id'])->delete();
                        //xoa cau tra loi
                        QuestionAnswer::whereIn('question_id',$question_childs)->delete();
                        // xoa log question
                        UserQuestionLog::whereIn('question_id',$question_childs)->delete();

                    }else{

                        QuestionAnswer::where('question_id',$model->attributes['id'])->delete();
                    }
                    UserQuestionLog::where('question_id',$model->attributes['id'])->delete();
                }
                if($model->attributes['type'] == self::TYPE_FLASH_SINGLE)
                {
                    UserQuestionLog::where('question_id',$model->attributes['id'])->delete();
                    //Question::where('parent_id',$model->attributes['id'])->delete();
                }
                if($model->attributes['type'] == self::TYPE_FLASH_MUTI)
                {
                    UserQuestionLog::where('question_id',$model->attributes['id'])->delete();
                    QuestionCardMuti::where('question_id',$model->attributes['id'])->delete();
                }                
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subQuestion()
    {
        return $this->hasMany(Question::class, 'parent_id', 'id');
    }

    public function type()
    {
        return self::TYPE[$this->getOriginal('type')];
    }

    /**
     * @return null|string
     */
    public function getImgBeforeAttribute()
    {
        return $this->getOriginal('img_before') ? asset($this->getOriginal('img_before')) : null;
    }

    /**
     * @return null|string
     */
    public function getImgAfterAttribute()
    {
        return $this->getOriginal('img_after') ? asset($this->getOriginal('img_after')) : null;
    }
}
