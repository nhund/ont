<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionCardMuti extends Model
{
    const STATUS_ON     = 1;
    const STATUS_OFF    = 2;

    const TYPE_FLASH_SINGLE = 1;
    const TYPE_FLASH_MUTI = 2;
    const TYPE_DIEN_TU = 3;
    const TYPE_TRAC_NGHIEM = 4;

    const REPLY_ERROR = 1;
    const REPLY_OK = 2;

    protected $table = 'question_flash_muti';
    protected $primaryKey = 'id';

    protected $fillable = [
    ];
    public $timestamps = false;

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
                
                if($model->attributes['question_id'] == $model->attributes['parent_id'])
                {
                    //xoa cac du lieu child
                    QuestionCardMuti::where('parent_id',$model->attributes['id'])->delete();
                }
            }
        });
    }
}
