<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kereta_trains_model extends Model
{
    protected $table = 'kereta_trains';
    protected $primaryKey = 'train_id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
}
