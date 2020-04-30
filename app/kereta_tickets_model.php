<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_tickets_model extends Model
{
    protected $table = 'kereta_tickets';
    protected $primaryKey = 'id_ticket';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function scheduleData(){
        
        return $this->belongsTo('App\kereta_schedules_model', 'id_schedule');
        
    }
}
