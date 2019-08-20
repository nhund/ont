<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    const STATUS_ON = 0;
    const STATUS_OFF = 1;

    protected $table = 'code';
    protected $primaryKey = 'id';

    protected $fillable = [
        'serial', 'code', 'created_at', 'updated_at'
    ];
    public $timestamps = false;
}
