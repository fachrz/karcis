<?php

namespace App\Http\Controllers;

use App\kc_admin_model;
use App\kc_users_model;
use App\kc_voucher_model;
use App\kereta_orders_model;
use App\kereta_passengers_model;
use App\kereta_stations_model;
use App\kereta_temp_orders_model;
use App\kereta_temp_passengers_model;
use App\kereta_tickets_model;
use App\Order\Order;
use App\pesawat_airports_model;
use App\pesawat_orders_model;
use App\pesawat_passengers_model;
use App\pesawat_schedules_model;
use App\pesawat_temp_orders_model;
use App\pesawat_temp_passengers_model;
use App\pesawat_tickets_model;
use App\Service\Pesawat\InvestigationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function showLoginPage()
    {
        if (Session::get('admin_status') == true && Session::get('admin_level') == 0) {
            return redirect('admin/dashboard');
        }else if (Session::get('admin_status') == true && Session::get('admin_level') == 1) {
            return redirect('admin/orders');
        }
        else {
            return view('Admin.LoginPage');
        }
    }

    public function logout()
    {
        Session::flush();
        return \redirect('/admin');
    }
    
    public function Authentication(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');

        $kc_admin = kc_admin_model::where('username', $username)->first();
        if ($kc_admin != null) {
            if (Hash::check($password, $kc_admin->password)) {

                Session::put('admin_username', $kc_admin->username);
                Session::put('admin_name', $kc_admin->admin_name);
                Session::put('admin_level', $kc_admin->level);
                Session::put('admin_thumbnail', $kc_admin->thumbnail);
                Session::put('admin_status', true);

                if ($kc_admin->level == '0') {
                    return redirect('/admin/dashboard');
                }elseif ($kc_admin->level == '1') {
                    return redirect('/admin/orders');
                }
            }else {
                return redirect('/admin')->with(['error' => 'Pasword yang anda masukan salah']);
            }
        }else{
            return redirect('/admin')->with(['error' => 'Akun Admin Tidak Terdaftar']);
        }
    }
    public function dashboard()
    {
        return \view('Admin.Dashboard');
    }

    public function orders(){
        return view('Admin.pesawat.OrdersPage');
    }

    public function paymentConfirmation(Request $request)
    {
        $payment_code = $request->input('payment-code');
            $pesawat_temporder = pesawat_temp_orders_model::select('cust_fullname', 'total_price', 'id_voucher')->where('payment_code', $payment_code)->first();

            if ($pesawat_temporder == null) {

                $pesawat_order = pesawat_orders_model::select('cust_fullname', 'total_price')->where('payment_code', $payment_code)->first();;


                if ($pesawat_order == null) {

                    $kereta_order = kereta_orders_model::select('cust_fullname', 'total_price')->where('payment_code', $payment_code)->first();;

                    if ($kereta_order == null) {
                        
                        $kereta_temporders = kereta_temp_orders_model::select('cust_fullname', 'total_price')->where('payment_code', $payment_code)->first();;

                        if ($kereta_temporders == null) {

                            return redirect('/admin/orders')->with(['orderMsg' => 'Kode pembayaran tidak ditemukan']);

                        }else {
                            $data = [
                                'total_price' => $kereta_temporders->total_price,
                                'cust_fullname' => $kereta_temporders->cust_fullname,
                                'payment_code' => $payment_code,
                                'location' => 'kereta_temp_orders_model'
                            ];
            
                            return redirect('/admin/orders')->with(['dataOrder' => $data]);
                        }

                    }else {

                        return redirect('/admin/orders')->with(['orderMsg' => 'Order sudah di konfirmasi']);

                    }


                }else {

                    return redirect('/admin/orders')->with(['orderMsg' => 'Order sudah di konfirmasi']);

    
                }
            }else {

                

                if ($pesawat_temporder->id_voucher != null) {
                    $voucher = kc_voucher_model::select('benefit')->where('id_voucher', $pesawat_temporder->id_voucher)->first();

                    $benefit = $voucher->benefit;
                }else {
                    $benefit = 0;
                }
                
                $data = [
                    'total_price' => $pesawat_temporder->total_price - $benefit,
                    'cust_fullname' => $pesawat_temporder->cust_fullname,
                    'payment_code' => $payment_code,
                    'location' => 'pesawat_temp_orders_model'
                ];

                return redirect('/admin/orders')->with(['dataOrder' => $data]);
            }
    
    }

    public function paymentvalidation(Request $request){
        $payment_code = $request->input('payment-code');
        $location = $request->input('location');

        if ($location == 'pesawat_temp_orders_model') {
            $pesawat_temporder = pesawat_temp_orders_model::with('tempPassenger', 'ticketData')->where('payment_code', $payment_code)->first();

            $pesawat_temppassenger = pesawat_temp_passengers_model::where('id_temp_order', $pesawat_temporder->id_temp_order);


            $pesawat_orders = new pesawat_orders_model();
            $pesawat_orders->id_order = $pesawat_temporder->id_temp_order;
            $pesawat_orders->id_ticket = $pesawat_temporder->id_ticket;
            $pesawat_orders->id_ticket2 = $pesawat_temporder->id_ticket2;
            $pesawat_orders->cust_fullname = $pesawat_temporder->cust_fullname;
            $pesawat_orders->cust_email = $pesawat_temporder->cust_email;
            $pesawat_orders->total_price = $request->input('total_price');
            $pesawat_orders->id_voucher = $pesawat_temporder->id_voucher;
            $pesawat_orders->payment_code = $pesawat_temporder->payment_code;

            if ($pesawat_orders->save()) {
                foreach ($pesawat_temporder->tempPassenger as $pto) { 
                    $pesawat_passenger = new pesawat_passengers_model();
                    $pesawat_passenger->title = $pto->title;
                    $pesawat_passenger->fullname = $pto->fullname;
                    $pesawat_passenger->type = $pto->type;
                    $pesawat_passenger->citizenship = $pto->citizenship;
                    $pesawat_passenger->id_order = $pto->id_temp_order;
                    $pesawat_passenger->save();
                }

                if ($pesawat_passenger->save()) {
                    
                    $email = $pesawat_temporder->cust_email;
                    $karcis_point = $pesawat_temporder->ticketData->karcis_point;
                    $checkusers = kc_users_model::where('email', $email);
                    if ($checkusers->exists()) {
                        $usersData = $checkusers->first();
                        $pointnow = $usersData->karcis_point;

                        $voucher = kc_voucher_model::where('id_voucher', $pesawat_orders->id_voucher)->first();

                        if ($voucher != null) {
                            $voucherpoint = $voucher->karcis_point;
                        }else {
                            $voucherpoint = 0;
                        }

                        $checkusers->update(['karcis_point'=>$pointnow + $karcis_point - $voucherpoint]);
                        $pesawat_temporder->delete();
                        $pesawat_temppassenger->delete();

                    }else {
                        $pesawat_temporder->delete();
                        $pesawat_temppassenger->delete();
                    }

                    $data = [
                        'email' => $pesawat_orders->cust_email,
                        'client_name' => $pesawat_orders->cust_fullname,
                        'subject' => 'E-ticket Karcis.com'
                    ];

                    $this->generateETicket($pesawat_orders->id_ticket, $pesawat_orders->id_order, $data, $pesawat_orders->id_ticket2);
                    
                                        
                    return redirect('/admin/orders')->with(['Success' => 'Pesanan Diterima']);
                }

        }
        }else if ($location == 'kereta_temp_orders_model') {

            $kereta_temporder = kereta_temp_orders_model::with('tempPassenger')->where('payment_code', $payment_code)->first();

            $kereta_temppassenger = kereta_temp_passengers_model::where('id_temp_order', $kereta_temporder->id_temp_order);

            $kereta_orders = new kereta_orders_model();
            $kereta_orders->id_order = $kereta_temporder->id_temp_order;
            $kereta_orders->id_ticket = $kereta_temporder->id_ticket;
            $kereta_orders->cust_fullname = $kereta_temporder->cust_fullname;
            $kereta_orders->cust_email = $kereta_temporder->cust_email;
            $kereta_orders->total_price = $kereta_temporder->total_price;
            $kereta_orders->payment_code = $kereta_temporder->payment_code;
            $kereta_orders->save();

            if ($kereta_orders->save()) {
                foreach ($kereta_temporder->tempPassenger as $pto) { 
                    $kereta_passenger = new kereta_passengers_model();
                    $kereta_passenger->title = $pto->title;
                    $kereta_passenger->fullname = $pto->fullname;
                    $kereta_passenger->type = $pto->type;
                    $kereta_passenger->citizenship = $pto->citizenship;
                    $kereta_passenger->id_order = $pto->id_temp_order;
                    $kereta_passenger->save();
                }

                if ($kereta_passenger->save()) {
                    
                    $email = $kereta_temporder->cust_email;

                    $kereta_temppassenger->delete();
                    $kereta_temporder->delete();

                    $data = [
                        'email' => $kereta_orders->cust_email,
                        'client_name' => $kereta_orders->cust_fullname,
                        'subject' => 'E-ticket Karcis.com'
                    ];

                    $this->keretaGenerateETicket($kereta_orders->id_ticket, $kereta_orders->id_order, $data);
                    
                    return redirect('/admin/orders')->with(['Success' => 'Pesanan Diterima']);
                }
            }

        }
    }

    public function generateETicket($idTiket, $id_order, $data, $idTiket2 = null)
    {
        $dataTickets = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->where('id_ticket', $idTiket)->first();

        $dataAirportFrom = pesawat_airports_model::select('airport_name', 'province')->where('id_airport', $dataTickets->scheduleData->flightData->airport_from)->first();

        $dataAirportTo = pesawat_airports_model::select('airport_name', 'province')->where('id_airport', $dataTickets->scheduleData->flightData->airport_to)->first();

        $dataDate = new Carbon($dataTickets->scheduleData->departure_date);

        $splitdatetime = explode(' ', $dataDate);

        $datetime = [
            'date' => Carbon::parse($splitdatetime[0])->format('l, d M Y'),
            'time' => Carbon::parse($splitdatetime[1])->format('H:i'),
        ];

        if ($idTiket2 != null) {
            $dataTickets2 = pesawat_tickets_model::with('scheduleData.flightData.airlineData')->where('id_ticket', $idTiket2)->first();

            $dataAirportFrom2 = pesawat_airports_model::select('airport_name', 'province')->where('id_airport', $dataTickets2->scheduleData->flightData->airport_from)->first();

            $dataAirportTo2 = pesawat_airports_model::select('airport_name', 'province')->where('id_airport', $dataTickets2->scheduleData->flightData->airport_to)->first();

            $dataDate2 = new Carbon($dataTickets2->scheduleData->departure_date);

            $splitdatetime2 = explode(' ', $dataDate2);

            $datetime2 = [
                'date2' => Carbon::parse($splitdatetime2[0])->format('l, d M Y'),
                'time2' => Carbon::parse($splitdatetime2[1])->format('H:i'),
            ];

            $datetimes = array_merge($datetime, $datetime2);
        }else {
            $dataTickets2  = null;
            $dataAirportFrom2 = null;
            $dataAirportTo2 = null;
            $datetimes = $datetime;
        }

        $dataPassenger = pesawat_passengers_model::where('id_order', $id_order)->get();

        $pdf = PDF::loadView('E-ticket', [
            'dataTiket' => $dataTickets,
            'dataTiket2' => $dataTickets2,
            'departure_date' => $datetimes,
            'airportFrom' => $dataAirportFrom,
            'airportTo' => $dataAirportTo,
            'airportFrom2' => $dataAirportFrom2,
            'airportTo2' => $dataAirportTo2,
            'passenger' => $dataPassenger,
        ]);
        

        return Mail::send('Mail.KarcisMail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->output(), "Eticket_karcis_com.pdf");
        });;
    }
    

    public function keretaGenerateETicket($idTiket, $id_order, $data)
    {
        $dataTickets = kereta_tickets_model::with('scheduleData.trainData')->where('id_ticket', $idTiket)->first();

        $dataStationFrom = kereta_stations_model::select('station_name', 'province')->where('id_station', $dataTickets->scheduleData->station_from)->first();

        $dataStationTo = kereta_stations_model::select('station_name', 'province')->where('id_station', $dataTickets->scheduleData->station_to)->first();

        $dataDate = new Carbon($dataTickets->scheduleData->departure_date);

        $splitdatetime = explode(' ', $dataDate);

        $datetime = [
            'date' => Carbon::parse($splitdatetime[0])->format('l, d M Y'),
            'time' => Carbon::parse($splitdatetime[1])->format('H:i'),
        ];

        $dataPassenger = kereta_passengers_model::where('id_order', $id_order)->get();

        $pdf = PDF::loadView('keretae-ticket', [
            'dataTiket' => $dataTickets,
            'departure_date' => $datetime,
            'stationFrom' => $dataStationFrom,
            'stationTo' => $dataStationTo,
            'passenger' => $dataPassenger,
        ]);

        return Mail::send('Mail.KarcisMail', $data, function($message)use($data, $pdf) {
                $message->to($data["email"], $data["client_name"])
                        ->subject($data["subject"])
                        ->attachData($pdf->output(), "Kereta-Eticket.pdf");
        });
    }

    public function ticketsadd(Request $request){
        $id_ticket = strtoupper($request->input('id-ticket'));
        $id_schedule = $request->input('id-schedule');
        if (empty($id_schedule)) {
            return redirect('/admin/pesawattickets')->with(['Error' => 'Jadwal tidak boleh kosong']);
        }
        $seat_class = $request->input('seat-class');
        $price = $request->input('price');

        $tickets = new pesawat_tickets_model();
        $tickets->id_ticket = $id_ticket;
        $tickets->id_schedule = $id_schedule;
        $tickets->seat_class = $seat_class;
        $tickets->price = $price;
        
        try {

            $tickets->save();
            return redirect('/admin/pesawattickets')->with(['Success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $e) {

            return redirect('/admin/pesawattickets')->with(['Error' => 'Data gagal ditambahkan']);
            
        }
    }

    /**
     * Voucher
     */

     public function showVoucherPage()
     {
         $voucher = kc_voucher_model::all();
         return view('admin.VoucherPage', [
             'voucher' => $voucher
         ]);
     }

     public function addVoucher(Request $request)
     {
         $voucher = new kc_voucher_model();
         $voucher->voucher_name = $request->input('voucher-name');
         $voucher->benefit = $request->input('benefit');
         $voucher->karcis_point = $request->input('karcis-point');
         
         try {
            $voucher->save();

            return redirect()->back()->with(['Success' => 'Voucher insert Success']);
         } catch (\Throwable $th) {
             return redirect()->back()->with(['Error' => 'Voucher Insert Error']);
         }

     }

     public function deleteVoucher($id_voucher)
     {
        $voucher = kc_voucher_model::find($id_voucher);
        $voucher->delete();
        
        return redirect()->back();
     }
}
