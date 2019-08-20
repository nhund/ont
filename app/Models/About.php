<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $table = 'about';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title','url','address','phone','email','about_us','page_facebook','group_facebook','create_date','logo','map','status','twitter','google','instagram','youtube','privacy_policy','terms'
    ];
    public $timestamps = false;
}