<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_stations_model extends Model
{
    protected $table = 'kereta_stations';
    protected $primaryKey = 'id_station';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
