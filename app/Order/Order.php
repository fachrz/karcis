<?php

namespace App\Order;

use App\kc_voucher_model;
use App\pesawat_tickets_model;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class Order
{
    public function priceCalculate($orderKey, $idVoucher = null)
    {
        $orderData = Cache::get($orderKey);

        $passenger = $orderData['passenger'];

        if ($orderData['idTiket2'] != null) {
            $dataTickets2 = pesawat_tickets_model::select('price')->where('id_ticket', $orderData['idTiket2'])->first();

            $price2 = $dataTickets2->price;

        }else {
            $price2 = 0;
        }

        $dataTickets = pesawat_tickets_model::select('price')->where('id_ticket', $orderData['idTiket'])->first();
    
        $totalPrice = ($dataTickets->price + $price2) * ($passenger['adult'] + $passenger['child'] + $passenger['baby']);

        if ($idVoucher != null) {
        
            $voucherBenefit = kc_voucher_model::select('benefit')->where('id_voucher', $idVoucher)->first();
    
            $priceWithVoucher =  $totalPrice - $voucherBenefit->benefit;
    
            return [
                'withvoucher' => true,
                'totalPrice' => $priceWithVoucher
            ];

        }else{

            $priceWithoutVoucher = $totalPrice;

            return [
                'withvoucher' => false,
                'totalPrice' => $priceWithoutVoucher
            ];

        }
       
    }
}
