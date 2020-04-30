<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kc_admin_model extends Model
{
    protected $table = 'karcis_admin';
    protected $primaryKey = "username";
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['username', 'password', 'admin_name', 'level', 'thumbnail'];
}
