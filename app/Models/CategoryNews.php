<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class CategoryNews extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    protected $table = 'category_news';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'status','create_at','update_at'
    ];
    public $timestamps = true;

    public function news()
    {
        return $this->hasMany(Post::class, 'category_id', 'id')->where('type', Post::NEWS);
    }
}