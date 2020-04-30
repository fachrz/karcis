<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_schedules_model extends Model
{
    protected $table = 'kereta_schedules';
    protected $primaryKey = 'id_schedule';
    public $incrementing = false;
    public $timestamps = false;

    public function trainData(){
        return $this->belongsTo('App\kereta_trains_model', 'train_id');
    }
    public function stationFromData(){
        return $this->belongsTo('App\kereta_stations_model', 'station_from');
    }
    public function stationToData(){
        return $this->belongsTo('App\kereta_stations_model', 'station_to');
    }
}
