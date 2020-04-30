<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesawat_flights_model extends Model
{
    protected $table = 'pesawat_flights';
    protected $primaryKey = 'flight_number';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function airlineData(){
        return $this->belongsTo('App\pesawat_airlines_model', 'airline_id');
    }

    public function scheduleData()
    {
        return $this->hasMany('App\pesawat_schedules_model', 'flight_number');
    }

    public function airportFromData()
    {
        return $this->belongsTo('App\pesawat_airports_model', 'airport_from');
    }

    public function airportToData()
    {
        return $this->belongsTo('App\pesawat_airports_model', 'airport_to');
    }
}
