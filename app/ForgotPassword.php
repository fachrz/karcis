<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPassword extends Model
{
    protected $table = 'karcis_forgotpass_req';
    protected $primaryKey = 'forgot_id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'forgot_id',
        'user_id', 
        'expr'
    ]; 
}
