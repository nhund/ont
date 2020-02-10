<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name','email','phone','content','create_at','user_id'
    ];
    public $timestamps = false;
}
