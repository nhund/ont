<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Code;

class UserCodeLog extends Model
{
    const STATUS_ERROR = 1;
    const STATUS_OK = 2;

    protected $table = 'user_code_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'code_id','code','status', 'created_at'
    ];
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();


        self::creating(function($model){
            
        });
        self::created(function($model){
            if (isset($model->attributes['code_id']) && $model->attributes['code_id'] > 0)
            {
                $code = Code::find($model->attributes['code_id']);
                if($code)
                {
                    $code->status = Code::STATUS_OFF;
                    $code->save();
                }                
            }
        });

        self::updating(function($model){

        });

        self::updated(function($model){

        });

        self::deleting(function($model){
            // ... code here
        });

        self::deleted(function($model){
            
        });
    }
}
