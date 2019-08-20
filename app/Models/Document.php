<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title', 'avatar', 'description', 'created_at', 'updated_at', 'content'
    ];
    public $timestamps = false;
}
