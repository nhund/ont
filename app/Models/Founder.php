<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Founder extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'founder';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title','name','img','content','status','create_at'
    ];
    public $timestamps = false;
}