<?php

namespace App\Http\Controllers;

use App\kc_users_model;
use App\kc_voucher_model;
use App\kereta_orders_model;
use App\kereta_temp_orders_model;
use Illuminate\Http\Request;
use App\pesawat_airports_model;
use App\pesawat_flights_model;
use App\pesawat_orders_model;
use App\pesawat_passengers_model;
use App\pesawat_temp_orders_model;
use App\pesawat_temp_passengers_model;
use App\pesawat_tickets_model;
use App\Services\CreationService;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

/**
 * Controller containing homepage
 * 
 * @author Fachrurozi
 */
class HomeController extends Controller
{
    
    /**
     * Show Home Page with checking Users Session
     * 
     */
    public function index()
    {   
        $airports = pesawat_airports_model::all();
    
        return \view('HomePage', compact('airports'));
    }

    public function getKarcisPoint()
    {
        $karcis_point = kc_users_model::select('karcis_point')->where('email', Session::get('email'))->first();

        return $karcis_point;      
    }

    public function getKarcisVoucher()
    {
        $userPoint = $this->getKarcisPoint();
        $getKarcisVoucher = kc_voucher_model::where('karcis_point' , '<=', $userPoint->karcis_point)->orderBy('karcis_point', 'DESC')->first();

        return $getKarcisVoucher;
    }

    //butuh form validation
    public function searchResult(Request $request)
    { 
    
        if (Session::has('departure_ticket')) {
            $departure = $request->a;
            $arrival = $request->d;
            $departureDate = $request->rd;
            $seatClass = $request->class;
        }else {
            $departure = $request->d;
            $arrival = $request->a;
            $departureDate = $request->dd;
            $seatClass = $request->class;
        }

        $tickets = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->whereHas('scheduleData.flightData', function($q) use($departure, $arrival, $seatClass, $departureDate){
            $q->where([
                ['airport_from', $departure],
                ['airport_to', $arrival],
                ['seat_class', $seatClass]
            ])->whereDate('departure_date', $departureDate);
        })->get(); 

        return view('ResultPage', [
            'tiketresult' => $tickets
        ]);
    }

    /**
     * 
     * Hstory Order
     */
    public function historyOrder(Request $request, CreationService $create)
    {
        $email = Session::get('email');

        //check order success
        $pesawatHistory = pesawat_orders_model::with('ticketData.scheduleData.flightData.airportFromData', 'ticketData.scheduleData.flightData.airportToData')->where('cust_email', $email)->get();
        $keretaHistory = kereta_orders_model::where('cust_email', $email)->get();
        
        return view('HistoryPage', [
            'pesawatHistory' => $pesawatHistory,
            'keretaHistory' => $keretaHistory,
        ]);
    }


    public function deleteHistoryOrder($id_order)
    {
        $historyOrder = pesawat_orders_model::find($id_order);
        $historyOrder->delete();
        
        return redirect()->back();
    }
    

    public function removeChoosedTicket()
    {

        Session::forget(['departure_ticket', 'destination_ticket']);

        return response([
            'message' => 'Reset Choosed Ticket Succesfull'
        ]);
    }

    public function ashiap()
    {
        return view('keretae-ticket');
    }
}

