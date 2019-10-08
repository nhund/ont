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

    protected $fillable = ['exam_id', 'part_1', 'part_2', 'part_3', 'part_4', 'part_5', 'part_6', 'part_7', 'part_8', 'part_9', 'part_10', 'created_at', 'updated_at'];
}