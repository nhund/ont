<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletLog extends Model
{
    const TYPE_NAP_XU = 1;
    const TYPE_MUA_KHOA_HOC = 2;

    protected $table = 'wallet_log';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id', 'type', 'xu_current','xu_change','note', 'created_at', 'updated_at'
    ];
    public $timestamps = false;
    
    public function user()
	{
		return $this->hasOne('App\User', 'id', 'user_id')->withDefault(['name'=>'']);
    }    

}
