<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class kc_voucher_model extends Model
{

    use SoftDeletes;

    protected $table = 'karcis_vouchers';
    protected $primaryKey = "id_voucher";
    public $timestamps = false;
    protected $dates = ['deleted_at'];
}
