<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'category';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'status', 'type','create_at'
    ];
    public $timestamps = false;

    public function course(){
        return $this->hasMany(Course::class);
    }
}
