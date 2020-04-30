<?php

namespace App\PesawatModels;

use Illuminate\Database\Eloquent\Model;

class TemporaryOrder extends Model
{
    protected $table = 'pesawat_temp_orders';
    protected $primaryKey = 'id_temp_order';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function tempPassenger()
    {
        return $this->hasMany('App\pesawat_temp_passengers_model', 'id_temp_order');
    }

    public function ticketData()
    {
        return $this->belongsTo('App\pesawat_tickets_model', 'id_ticket');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
             $user->tempPassenger()->delete();
             // do the rest of the cleanup...
        });
    }
}
