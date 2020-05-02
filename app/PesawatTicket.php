<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesawatTicket extends Model
{
    protected $table = 'pesawat_tickets';
    protected $primaryKey = 'id_ticket';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    public function pesawat_schedules(){
        return $this->belongsTo('App\pesawat_schedules_model', 'id_schedule');
    }

    public function scheduleData()
    {
        return $this->belongsTo('App\pesawat_schedules_model', 'id_schedule');
    }
}
