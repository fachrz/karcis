<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\kc_users_model;
use App\kc_voucher_model;
use App\kereta_orders_model;
use App\kereta_temp_orders_model;
use App\Mail\KarcisEmail;
use App\Order\Order;
use App\Order\Voucher;
use App\pesawat_orders_model;
use App\pesawat_temp_orders_model;
use App\pesawat_temp_passengers_model;
use App\pesawat_tickets_model;
use App\Service\Pesawat\InvestigationService;
use App\Services\CreationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

/**
 * 
 * 
 */
class OrderController extends Controller
{
    public function prepareOrderForm(Request $request, CreationService $create, InvestigationService $investigate
    )
    {
        $orderKey = $create->code(15, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $exptime = Carbon::now()->addSeconds(1800)->toDateTimeString();
        
        $orderData = $request->all() + ['exptime' => $exptime, 'idTiket' => Session::get('departure_ticket'), 'idTiket2' => Session::get('destination_ticket')];
        
        $ticketAvailibilty = $investigate->isTicketAvailable(array_sum($orderData['passenger']), $orderData['idTiket'], $orderData['idTiket2']?:null);

        if ($ticketAvailibilty == true) {
            if (Cache::get($orderKey)) {
                $status = "failed";
                $statusCode = 400;
            }else {
                Cache::put($orderKey, $orderData, 1800);
    
                $status = "succeed";
                $statusCode = 200;
            }

            Session::forget(['departure_ticket', 'destination_ticket']);

            return response([
                'key' => $orderKey,
                'status' => $status,
            ], $statusCode);
        }else {
        
            return response([
                'status' => 'Ticket unavailable'
            ], 400);
        }

        
    }
    
    public function showOrderForm($orderKey)
    {
        $orderdata = Cache::get($orderKey);

        $passenger = $orderdata['passenger'];
 
        if ($orderdata) {
            $dataTickets = pesawat_tickets_model::with('scheduleData.flightData')->where('id_ticket',$orderdata['idTiket'])->first();

            $dataTickets2 = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->where('id_ticket',$orderdata['idTiket2'])->first();

            if ($dataTickets2) {
                $price = $dataTickets->price + $dataTickets2->price;
            }else {
                $price = $dataTickets->price;
            }
            
            $totalprice = $price * ($passenger['adult'] + $passenger['child'] + $passenger['baby']);

            
            
            if (Session::get('status') == 1) {
                $karcis_point = kc_users_model::select('karcis_point')->where('email', Session::get('email'))->first();

                $getVoucher = kc_voucher_model::where('karcis_point' , '<=', $karcis_point->karcis_point)->orderBy('karcis_point', 'DESC')->first();
            }else {
                $getVoucher = false;
            }
        }else {

            return "Sepertinya ada yang salah"; 
 
        }        
        return view('OrderPage', [
            'Tiketdata' => $dataTickets,
            'Tiketdata2' => $dataTickets2?:null,
            'adult' => $passenger['adult'], 
            'child' => $passenger['child'], 
            'baby' => $passenger['baby'], 
            'totalprice' => $totalprice,
            'exptime' => $orderdata['exptime'],
            'voucher' => $getVoucher
        ]);

    } 

    /**
     * Claiming voucher
     * 
     * @param Request $request
     * @param Voucher $voucher
     */
    public function voucherClaim(Request $request, Voucher $voucher){
        
        $checkPoint = $voucher->isPointSufficient($request->voucherId, Session::get('email')); 

        if ($checkPoint == true) { 

            if (Session::has('id-voucher')) {

                Session::forget('id-voucher');

                return Response::make([
                    'msg_code' => '4sc1e28',
                    'message' => 'Voucher_Unclaimed'
                ]);
                
            }else{

                Session::put('id-voucher', $request->voucherId);

            }
        }else{

            return response([
                'msg_code' => '3er2r13',
                'message' => 'Not_Enough_Point'
            ]);
            
        }
    }

    /**
     * Check if voucher whether Claimed or not
     * 
     * @param Request $request
     * @param Order $order
     */
    public function isVoucherClaimed(Request $request, Order $order)
    {
        $totalPrice = $order->priceCalculate($request->orderKey, Session::get('id-voucher'));

        if ($totalPrice['withvoucher']) {

            return Response::make([
                'msg_code' => '4sc1e39',
                'message' => 'Voucher_Has_Claimed',
                'totalPrice' => $totalPrice['totalPrice']
            ]);

        }else {

            return Response::make([
                'msg_code' => '4er1e39',
                'message' => 'Voucher_not_Claimed',
                'totalPrice' => $totalPrice['totalPrice']
            ]);
            
        }
    }

    public function getPrice($orderKey)
    {
        $orderdata = Cache::get($orderKey);

        $passenger = $orderdata['passenger'];
    
        $dataTickets = pesawat_tickets_model::with('scheduleData.flightData')->where('id_ticket',$orderdata['idTiket'])->first();

        $dataTickets2 = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->where('id_ticket',$orderdata['idTiket2'])->first();

        if ($dataTickets2) {
            $price = $dataTickets->price + $dataTickets2->price;
        }else {
            $price = $dataTickets->price;
        }

        $totalPrice = $price * ($passenger['adult'] + $passenger['child'] + $passenger['baby']);

        return $totalPrice;
    }
   
    /**
     * Order Process here
     * 
     * @param OrderRequest $request will validate all incoming request
     * @param InvestigationService $investigate blessed by the ability to investigate
     * @param CreationService $create blessed by the ability to create
     * @return void
     */
    public function orderProcess(OrderRequest $request, InvestigationService $investigate, CreationService $create, Order $order)
    {
        $orderKey = $request->orderKey;
        $passTitle = $request->pass_title;
        $passFullname = $request->pass_fullname;
        $passCitizenship = $request->pass_state;
        $passType = $request->pass_type;

        $orderData = Cache::get($orderKey);

        $customerData = [
            'cust_fullname' => $request->cust_fullname,
            'cust_email' => $request->cust_email,
        ];

        $typeAuthenticity = $investigate->isTypeAuthentic($passType, $orderKey);

        $ticketAvailability = $investigate->isTicketAvailable(array_sum($orderData['passenger']), $orderData['idTiket'], $orderData['idTiket2']);

        if ($ticketAvailability == true && $typeAuthenticity == true) {

            $orderId = $create->orderId($orderKey);
            
            $paymentCode = $create->paymentCode($orderKey); 

            $temporder = new pesawat_temp_orders_model();
            $temporder->id_temp_order  = $orderId;
            $temporder->id_ticket = $orderData['idTiket'];
            $temporder->id_ticket2 = $orderData['idTiket2'] ?: null;
            $temporder->cust_fullname = $customerData['cust_fullname'];
            $temporder->cust_email = $customerData['cust_email'];
            $temporder->total_price = $this->getPrice($request->orderKey);
            $temporder->exptime = Carbon::now()->addSeconds(7200)->toDateTimeString();
            $temporder->id_voucher = session::get('id-voucher');
            $temporder->payment_code = $paymentCode;

            if ($temporder->save()) {

                for ($i=0; $i < count($passFullname) ; $i++) { 
                    $temppassenger = new pesawat_temp_passengers_model();
                    $temppassenger->title = $passTitle[$i];
                    $temppassenger->fullname = $passFullname[$i];
                    $temppassenger->type = $passType[$i];
                    $temppassenger->citizenship = $passCitizenship[$i];
                    $temppassenger->id_temp_order = $orderId;
                    $temppassenger->save();
                }

                Cache::put($orderKey, $customerData['cust_email']);

                return response([
                    'status' => "success",
                    'order_key' => $orderKey,
                    'order_id' => $orderId     
                ], 200);

            }
            
        }else if($ticketAvailability == false){

            return 'Maaf tiket sudah habis';

        }elseif ($typeAuthenticity == false) {

            return Response([
                'msg_code' => '5er0x01',
                'message' => 'Type_isNot_Authentic'
            ], 406);

        }
        
    }

    public function sendmail($order_key, $order_id){

        $customer_email = Cache::get($order_key);
        
        // if you need to use an email function, run your Mail in here.
        // Activate below if you wan't to use default Mail. 

        $data = [
            'link' => url("order/payment/".$order_id),
            'customer_email' => $customer_email
        ]; 

        Mail::send('Mail.KarcisOrderMail', $data, function($message)use($data) {
            $message->to($data['customer_email'])
                    ->subject('Karcis Order');
        });

        Cache::forget($order_key);

        if (Session::has('id-voucher')) {
            Session::forget('id-voucher');
        }

        return redirect("order/payment/".$order_id);
        
    }
    public function payment($id)
    {
        $id_temp_order = strtoupper($id);
        $temporder =  pesawat_temp_orders_model::with('voucherData')->select('total_price', 'id_voucher', 'exptime', 'payment_code')->where('id_temp_order', $id_temp_order)->first();

        $datetime_now = Carbon::now()->toDateTimeString();
        if ($temporder->exptime <= $datetime_now) {
    
            return 'Maaf sudah expired';

        }else {

            if ($temporder->id_voucher == null) {
                $totalPrice = $temporder->total_price;
            }else {
                $totalPrice = $temporder->total_price - $temporder->voucherData->benefit;
            }
            
            return \view('PaymentPage', [
                'payment_code' => $temporder->payment_code,
                'exptime' => $temporder->exptime,
                'totalPrice' => $totalPrice
            ]);
        }
    }

    public function getchooseticket()
    {
        if (Session::has('departure_ticket')) {
            $ticketModel = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->where('id_ticket', Session::get('departure_ticket'))->first();

            $departure_ticket = [
                'from' => $ticketModel->scheduleData->flightData->airport_from,
                'to' => $ticketModel->scheduleData->flightData->airport_to,
                'date' => $ticketModel->scheduleData->departure_date,
                'price' => "Rp " . number_format($ticketModel->price,2,',','.'),
                'airline' => $ticketModel->scheduleData->flightData->airlineData->airline_logo
            ];

            return response([
                'message' => 'departure_ticket_has_been_set',
                'departure_ticket' => $departure_ticket,
            ]);
        }else {
            return response([
                'message' => 'departure_ticket_not_set',
                'departure_ticet' => null
            ]);
        }
    }

    public function setchooseticket(Request $request)
    {
        $idTiket = $request->idTiket;

        if (session::has('departure_ticket')) {
            session()->put('destination_ticket', Session::get('departure_ticket') == $idTiket ? null : $idTiket);

            return response([
                'message' => true,
                'departure_ticket' => Session::get('departure_ticket'),
                'destination_ticket' => Session::get('destination_ticket')  
            ]);
        }else {
            session()->put('departure_ticket', $idTiket);

            return response([
                'message' => 'departure_ticket'
            ]);
        }

       
    }
}
