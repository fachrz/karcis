<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesawatAircraft extends Model
{
    protected $table = 'pesawat_aircrafts';
    protected $primaryKey = 'aircraft_registry';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function airlinesData(){
        return $this->belongsTo('App\pesawat_airlines_model', 'airline_id');
    }
}
