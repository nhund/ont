<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $table = 'user_wallet';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'xu', 'status', 'created_at', 'updated_at'
    ];
    public $timestamps = false;
  
}
