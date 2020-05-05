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
    const STOPPED = 'Stopped';

    public $timestamps = true;

    protected $fillable = ['second_stop_highest','last_submit_at','begin_highest_at', 'lesson_id', 'user_id', 'turn', 'score', 'time', 'status_stop', 'second_stop', 'begin_at', 'stopped_at', 'until_number', 'turn_stop', 'last_at'];

    protected $appends = ['doing_time', 'still_time'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDoingTimeAttribute()
    {
        $second = strtotime($this->getOriginal('last_at')) - strtotime($this->getOriginal('begin_at')) - $this->getOriginal('second_stop');
        $minutes  = floor($second/60);
		$hours = 0;
        if($minutes >= 60){
        	$hours = floor($minutes/60);
			$minutes = floor($minutes%60);
		}
        $second = floor($second%60);
        return $hours > 0 ? "{$hours}h{$minutes}m{$second}s" : ($minutes > 0 ? "{$minutes}m{$second}s" : "{$second}s");
    }

    public function getDoingTimeHighestAttribute()
    {
        $second = strtotime($this->getOriginal('last_submit_at')) - strtotime($this->getOriginal('begin_highest_at')) - $this->getOriginal('second_stop_highest');
		$minutes  = floor($second/60);
		$hours = 0;
		if($minutes >= 60){
			$hours = floor($minutes/60);
			$minutes = floor($minutes%60);
		}
		$second = floor($second%60);
		return $hours > 0 ? "{$hours}h{$minutes}m{$second}s" : ($minutes > 0 ? "{$minutes}m{$second}s" : "{$second}s");
    }

    public function getStillTimeAttribute()
    {
        $seconds = ($this->time*60) + $this->getOriginal('second_stop');
        return date('Y-m-d H:i:s',$this->getOriginal('begin_at') ? strtotime($this->getOriginal('begin_at')) + $seconds : $seconds);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'lesson_id', 'lesson_id');
    }
}
