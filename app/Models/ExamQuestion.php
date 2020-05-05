<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{

    protected $table = 'exam_question';

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'question_id', 'part', 'created_at', 'updated_at', 'times'];
}