<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesawatAirline extends Model
{
    protected $table = 'pesawat_airlines';
    protected $primaryKey = 'airline_id';
    public $incrementing = true;
    public $timestamps = false;

    public function aircraftsData(){
        return $this->hasMany('App\pesawat_aircrafts_model', 'airline_id');
    }

    public function flightsData(){
        return $this->hasMany('App\pesawat_flights_model', 'airline_id');
    }
}
