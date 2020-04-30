<?php

namespace App\Order;

use App\kc_users_model;
use App\kc_voucher_model;

/**
 * All voucher stuff placed in here
 * 
 * @author Fachrurozi
 */
class Voucher
{
    /**
     * checking whether point is sufficient to use
     * 
     * @param String $voucherId
     * @param String $email
     * @return bool
     */
    public function isPointSufficient($voucherId, $email)
    {
        $voucherPoint = kc_voucher_model::where('id_voucher', $voucherId)->first(); 

        $usersModel = kc_users_model::select('karcis_point')->where('email', $email)->first();

        $pointCalculate = $usersModel->karcis_point - $voucherPoint->karcis_point;

        if ($pointCalculate >= 0) {

            return true;

        }else {

            return false;
            
        }
    }
}
