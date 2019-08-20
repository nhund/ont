<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFeel extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'user_feel';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'name', 'school', 'avatar', 'create_date','status'
    ];
    public $timestamps = false;

    
}
