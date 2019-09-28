<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamUser extends Model
{
    protected $table = 'exam_user';

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'user_id', 'turn', 'score', 'last_submit_at'];
}
