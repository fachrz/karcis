<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'karcis_users';
    protected $primaryKey = 'email';
    public $incerementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'email', 
        'password', 
        'first_name', 
        'last_name', 
        'telp', 
        'karcis_point', 
        'account_type', 
    ];        
}
