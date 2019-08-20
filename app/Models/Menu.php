<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;
    protected $table = 'menu';
    protected $primaryKey = 'id';

    protected $fillable = [
        'parent_id','name','url','menu_order','create_date','status'
    ];
    public $timestamps = false;
}
