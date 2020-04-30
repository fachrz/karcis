<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_temp_passengers_model extends Model
{
    protected $table = 'kereta_temp_passengers';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
