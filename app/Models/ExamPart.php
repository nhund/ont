<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamPart extends Model
{

    protected $table = 'exam_part';

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public static function boot()
    {
        parent::boot();

        self::deleted(function ($model){
            ExamQuestion::where([
                'lesson_id' => $model->lesson_id,
                'part' => $model->id]
            )->delete();
        });
    }

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'name', 'score', 'created_at', 'updated_at', 'number_question'];

    protected $hidden = ['updated_at', 'created_at'];

    public function userExamAnswer(){
        return $this->hasMany(ExamUserAnswer::class, 'part');
    }
}