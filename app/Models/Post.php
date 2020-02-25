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
    const BEST_FEATURE = 2;
    const NORMAL = 0;

    protected $table = 'post';
    protected $primaryKey = 'id';

    protected $fillable = [
        'category_id', 'name', 'url', 'content','des','avatar','status','sicky','seo_title','seo_description','feature','seo_keyword','create_date','update_date'
    ];

    protected $appends = ['created_at'];

    public $timestamps = false;

    public function getThumbnailAttribute()
    {
        $path = "/public/images/news/{$this->getOriginal('id')}/480_320/{$this->getOriginal('avatar')}";
        return asset($path);
    }

    public function getCreatedAtAttribute()
    {
        $to_time = $this->getOriginal('create_date');
        $from_time = strtotime(now());

        $minutes =  round(abs($to_time - $from_time) / 60,2);

        if ($minutes < 60){
             return "{$minutes} phút trước";
        }

        if ($minutes > 60 && $minutes < 1440){
            $hours = round($minutes/60);
            return "{$hours} giờ trước";
        }

        $days = round($minutes/1440);
        return "{$days} ngày trước";
    }

    public function category()
    {
        return $this->belongsTo(CategoryNews::class, 'category_id');
    }
}
