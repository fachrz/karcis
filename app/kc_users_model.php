<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kc_users_model extends Model
{
    protected $table = 'karcis_users';
    protected $primaryKey = 'email';
    public $incerementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = ['email', 'password', 'first_name', 'last_name', 'telp', 'karcis_point', 'account_type', 'account_created_at'];
}
