<?php

namespace App\Service\Pesawat;

use App\kereta_temp_orders_model;
use App\kereta_temp_passengers_model;
use App\kereta_tickets_model;
use App\pesawat_orders_model;
use App\pesawat_temp_orders_model;
use App\pesawat_temp_passengers_model;
use App\pesawat_tickets_model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * This Method will serve you to investigating something. 
 * 
 * All Capabilities that are in this service, fully endowed by you.
 * 
 * @author Fachrurozi
 */
class InvestigationService
{
    
    /**
     * check if passenger type is same as the one in the ticket.
     * 
     */
    public function isTypeAuthentic(array $passType, $orderKey)
    {

        $orderData = Cache::get($orderKey);

        $passenger = $orderData['passenger'];

        $typeFromRequest = [
            'adult' => $passenger['adult'],
            'child' => $passenger['child'],
            'baby' => $passenger['baby']
        ];
        $typeFromOrderForm = array_count_values($passType);
        $diffType = array_diff_assoc($typeFromOrderForm, $typeFromRequest);

        if (empty($diffType)) {

            return true;

        }else{

            return false;

        }
        
    }

    /**
     * check if passenger type is same as the one in the ticket.
     * 
     */
    public function isKeretaTypeAuthentic(array $passType, $orderKey)
    {

        $orderData = Cache::get($orderKey);

        $passenger = $orderData['passenger'];

        $typeFromRequest = [
            'adult' => $passenger['adult'],
            'baby' => $passenger['baby']
        ];
        $typeFromOrderForm = array_count_values($passType);
        $diffType = array_diff_assoc($typeFromOrderForm, $typeFromRequest);

        if (empty($diffType)) {

            return true;

        }else{

            return false;

        }
        
    }

    /**
     * Cek apakah tiket tersedia atau tidak
     * 
     * @param $currentTempPassenger 
     */
    public function isTicketAvailable(int $currentTempPassenger, $ticketId, $ticketId2 = null)
    {
        $dateTimeNow = Carbon::now()->toDateTimeString();
        $collectedIdTemporder = pesawat_temp_orders_model::select('id_temp_order')->where([['id_ticket', $ticketId], ['exptime', '>=', $dateTimeNow ]])->orWhere('id_ticket2', $ticketId2)->pluck('id_temp_order')->toArray();
        
        if (empty($collectedIdTemporder)) {

            return true;
            
        }else{
            $countTempPassenger = pesawat_temp_passengers_model::where('id_temp_order', $collectedIdTemporder)->count();

            $ticketData = pesawat_tickets_model::where('id_ticket', $ticketId)->first();
            
            $seatClass = $ticketData->seat_class."_quota";

            $countSeatClass = $ticketData->$seatClass;

            if (($countTempPassenger + $currentTempPassenger) <= $countSeatClass) {

                return true;

            }else{

                return false;

            }
        } 
    }

    /**
     * Cek apakah tiket tersedia atau tidak
     * 
     * @param $currentTempPassenger
     * @param $ticketId
     */
    public function isKeretaTicketAvailable(int $currentTempPassenger, $ticketId)
    {
        $dateTimeNow = Carbon::now()->toDateTimeString();
        $collectedIdTemporder = kereta_temp_orders_model::select('id_temp_order')->where([['id_ticket', $ticketId], ['exptime', '>=', $dateTimeNow ]])->pluck('id_temp_order')->toArray();
        
        if (empty($collectedIdTemporder)) {

            return true;
            
        }else{
            $countTempPassenger = kereta_temp_passengers_model::where('id_temp_order', $collectedIdTemporder)->count();

            $ticketData = kereta_tickets_model::where('id_ticket', $ticketId)->first();
            
            $seatClass = $ticketData->seat_class."_quota";

            $countSeatClass = $ticketData->$seatClass;

            if (($countTempPassenger + $currentTempPassenger) <= $countSeatClass) {

                return true;

            }else{

                return false;

            }
        } 
    }

}
