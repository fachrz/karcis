<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_orders_model extends Model
{
    protected $table = 'kereta_orders';
    protected $primaryKey = 'id_order'; 
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
