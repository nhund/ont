<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id','course_id','rating_value','create_at'
    ];
    public $timestamps = false;
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }    
}
