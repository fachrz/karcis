<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesawat_airports_model extends Model
{
    protected $table = 'pesawat_airports';
    protected $primaryKey = 'id_airport';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
