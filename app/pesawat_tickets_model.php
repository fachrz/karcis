<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class pesawat_tickets_model extends Model
{
    protected $table = 'pesawat_tickets';
    protected $primaryKey = 'id_ticket';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function pesawat_schedules(){
        return $this->belongsTo('App\pesawat_schedules_model', 'id_schedule');
    }

    public function scheduleData()
    {
        return $this->belongsTo('App\pesawat_schedules_model', 'id_schedule');
    }
}
