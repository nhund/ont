<?php
/**
 * Created by PhpStorm.
 * User: nhund
 * Date: 24/09/2019
 * Time: 16:00
 */

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ExamUser extends Model
{
    protected $table = 'exam_user';

    const ACTIVE = 'Active';
    const INACTIVE = 'Inactive';

    public $timestamps = true;

    protected $fillable = ['lesson_id', 'user_id', 'turn', 'score', 'time'];

    protected $appends = ['doing_time', 'still_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDoingTimeAttribute()
    {
        return  $doingTime  = (strtotime($this->last_at) - strtotime($this->begin_at) - $this->second_stop)/60;
    }

    public function getStillTimeAttribute()
    {
        return  $doingTime  = strtotime(now()->addMinutes($this->time)) - strtotime($this->begin_at) - $this->second_stop;
    }
}
