<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pesawat_orders_model extends Model
{
    use SoftDeletes;

    protected $table = 'pesawat_orders';
    protected $primaryKey = 'id_order'; 
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $dates = ['deleted_at'];

    public function ticketData(){
        return $this->belongsTo('App\pesawat_tickets_model', 'id_ticket');
    }
}
