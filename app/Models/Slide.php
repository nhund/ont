<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'slide';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title','url','slide_order','create_date','content','img','status'
    ];
    public $timestamps = false;
}
