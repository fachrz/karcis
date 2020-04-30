<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_temp_orders_model extends Model
{
    protected $table = 'kereta_temp_orders';
    protected $primaryKey = 'id_temp_order';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function tempPassenger(){
        return $this->hasMany('App\kereta_temp_passengers_model', 'id_temp_order');
    }
}
