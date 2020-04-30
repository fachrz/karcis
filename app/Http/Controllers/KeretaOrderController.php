<?php

namespace App\Http\Controllers;

use App\kereta_temp_orders_model;
use App\kereta_temp_passengers_model;
use App\kereta_tickets_model;
use App\Mail\KarcisEmail;
use App\Service\Pesawat\InvestigationService;
use App\Services\CreationService;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use RandomLib\Factory;

class KeretaOrderController extends Controller
{
    public function keretachooseorder(Request $request, CreationService $create, InvestigationService $investigate)
    {
        $orderKey = $create->code(15, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890');

        $exptime = Carbon::now()->addSeconds(1800)->toDateTimeString();

        $orderData = $request->all() + ['exptime' => $exptime];

        $ticketAvailibility = $investigate->isKeretaTicketAvailable(array_sum($orderData['passenger']), $orderData['idTiket']);

        if ($ticketAvailibility == true) {
            if (Cache::get($orderKey)) {
                $status = "failed";
                $statusCode = 400;
            }else {
                Cache::put($orderKey, $orderData, 1800);
                $status = "succeed";
                $statusCode = 200;
            }
            
            return \response([
                'key' => $orderKey,
                'status' => $status,
            ], $statusCode);

        }else {
            return response([
                'status' => 'Ticket unavailable'
            ], 400);
        }
        

        
    }public function showOrderForm($orderkey)
    {
        $orderdata = Cache::get($orderkey);

        $passenger = $orderdata['passenger']; 

        if ($orderdata) {
            $dataTickets = kereta_tickets_model::with('scheduleData.trainData')->where('id_ticket', $orderdata['idTiket'])->first();
            
            $totalprice = $dataTickets->price * ($passenger['adult'] + $passenger['baby']);
        }else {
            return "Sepertinya ada yang salah";
        }
        
        return view('kereta.OrderPage', [
            'Tiketdata' => $dataTickets,
            'adult' => $passenger['adult'], 
            'baby' => $passenger['baby'], 
            'totalprice' => $totalprice,
            'exptime' => $orderdata['exptime']
        ]);
    }

    public function getPrice($orderKey)
    {
        $orderdata = Cache::get($orderKey);

        $passenger = $orderdata['passenger'];
    
        $dataTickets = kereta_tickets_model::with('scheduleData')->where('id_ticket',$orderdata['idTiket'])->first();

        $totalPrice = $dataTickets->price * ($passenger['adult'] + $passenger['baby']);

        return $totalPrice;
    }
    
    public function orderprocess(Request $request, InvestigationService $investigate, CreationService $create)
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

        $typeAuthenticity = $investigate->isKeretaTypeAuthentic($passType, $orderKey);

        $ticketAvailability = $investigate->isKeretaTicketAvailable(array_sum($orderData['passenger']), $orderData['idTiket']);

        if ($ticketAvailability == true && $typeAuthenticity == true) {

            $orderId = $create->orderId($orderKey);
            
            $paymentCode = $create->paymentCode($orderKey); 

            $temporder = new kereta_temp_orders_model();
            $temporder->id_temp_order  = $orderId;
            $temporder->id_ticket = $orderData['idTiket'];
            $temporder->cust_fullname = $customerData['cust_fullname'];
            $temporder->cust_email = $customerData['cust_email'];
            $temporder->total_price = $this->getPrice($request->orderKey);
            $temporder->exptime = Carbon::now()->addSeconds(7200)->toDateTimeString();
            $temporder->payment_code = $paymentCode;

            if ($temporder->save()) {

                for ($i=0; $i < count($passFullname) ; $i++) { 
                    $temppassenger = new kereta_temp_passengers_model();
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
            'link' => url("keretaorder/payment/".$order_id),
            'customer_email' => $customer_email
        ]; 

        Mail::send('Mail.KarcisOrderMail', $data, function($message)use($data) {
            $message->to($data['customer_email'])
                    ->subject('Karcis Order');
        });
        
        Cache::forget($order_key); 

        return redirect("keretaorder/payment/".$order_id);
        
    }

    public function payment($order_id)
    {
        $id_temp_order = strtoupper($order_id);
        $temporder =  kereta_temp_orders_model::select('total_price', 'exptime', 'payment_code')->where('id_temp_order', $id_temp_order)->first();

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
}
