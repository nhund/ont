<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'school';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'city', 'status', 'create_at'
    ];
    public $timestamps = false;
  
}
