<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    const NEWS = 'news';
    const POSTING = 'posting';

    const FEATURE = 1;
    const NORMAL = 0;

    protected $table = 'post';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id', 'name', 'url', 'content','des','avatar','status','sicky','seo_title','seo_description','feature','seo_keyword','create_date','update_date'
    ];
    public $timestamps = false;
  
}
