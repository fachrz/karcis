<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesawat_temp_passengers_model extends Model
{
    protected $table = 'pesawat_temp_passengers';
    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

}
