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

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'name', 'score', 'created_at', 'updated_at'];
}