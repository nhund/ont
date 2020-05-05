<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'error';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['request_uri', 'method', 'parameters', 'message','code', 'file', 'line', 'trace', 'create_date','is_read'];

    public $timestamps = false;
}
