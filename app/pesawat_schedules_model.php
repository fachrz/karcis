<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pesawat_schedules_model extends Model
{
    protected $table = 'pesawat_schedules';
    protected $primaryKey = 'id_schedule';
    public $incrementing = false;
    public $timestamps = false;

    public function aircraftData(){
        return $this->belongsTo('App\pesawat_aircrafts_model', 'aircraft_registry');
    }
    public function flightData(){
        return $this->belongsTo('App\pesawat_flights_model', 'flight_number');
    }

    public function pesawat_aircrafts(){
        return $this->belongsTo('App\pesawat_aircrafts_model', 'aircraft_registry');
    }
    public function IdScheduleData(){
        return $this->hasOne('App\pesawat_tickets_model', 'id_schedule');
    }
    
    
    public function ticketData()
    {
        return $this->hasOne('App\pesawat_tickets_model', 'id_schedule');
    }

}
