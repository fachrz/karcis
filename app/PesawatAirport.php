<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesawatAirport extends Model
{
    protected $table = 'pesawat_airports';
    protected $primaryKey = 'id_airport';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
}
