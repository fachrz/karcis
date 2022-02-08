<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    
    protected $table = 'karcis_users';
    protected $primaryKey = 'user_id';
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
