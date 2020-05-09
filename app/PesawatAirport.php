<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PesawatAirport extends Model
{
    use SoftDeletes;
    
    protected $table = 'pesawat_airports';
    protected $primaryKey = 'id_airport';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];
}
