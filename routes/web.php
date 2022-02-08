<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

/* Authentication Route */
Route::get('/login', 'AuthController@showLoginForm');
Route::post('/login', 'AuthController@login');
Route::get('/register', 'AuthController@showRegisterForm');
Route::post('/register', 'AuthController@register');
Route::get('/logout', 'AuthController@logout');

/* Third Party Authentication Route */
Route::post('/login/tpa', 'AuthController@thirdPartyAuthentication');

/* Home Route */
Route::get('/', 'PesawatController@showHomePage');
//history Order
Route::get('/historyorder', 'HomeController@historyOrder');
Route::get('/historyorder/delete/{id_order}', 'HomeController@deleteHistoryOrder');


/* Pesawat Route */
Route::get('/', 'HomeController@index');
Route::get('/flight/search', 'HomeController@searchResult');
Route::post('/chooseorder', 'OrderController@prepareOrderForm'); //AJAX
Route::get('/cart/flight/{orderKey}', 'OrderController@showOrderForm');
Route::post('/order', 'OrderController@orderProcess'); //AJAX
Route::get('/order/payment/{order_id}', 'OrderController@payment');
Route::get('/order/eticket/{order_id}', 'OrderController@e_ticket');

 
/* Kereta Route */
Route::get('/kereta', 'KeretaController@index');
Route::get('/kereta-api/cari', 'KeretaController@searchResult');
Route::post('/keretachooseorder', 'KeretaOrderController@keretachooseorder'); //AJAX
Route::get('/cart/kereta/{orderKey}', 'KeretaOrderController@showOrderForm');
Route::post('/keretaorder', 'KeretaOrderController@orderprocess'); //AJAX
Route::get('/keretaorder/payment/{order_id}', 'KeretaOrderController@payment');
Route::get('/order/eticket/{order_id}', 'OrderController@e_ticket');

/* Admin Route */
Route::get('/admin', 'AdminController@showLoginPage');
Route::post('/admin/auth', 'AdminController@Authentication');
Route::get('/admin/orders', 'AdminController@orders');
Route::post('/admin/ordersconfirmation', 'AdminController@paymentConfirmation');
Route::post('/admin/orders/validation', 'AdminController@paymentvalidation');
Route::get('/admin/logout', 'AdminController@logout');


Route::group(['middleware' => ['mymiddleware']], function () {
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/paymentvalidation', 'AdminController@paymentvalidation');
    
    /* Admin Voucher */
    Route::get('/admin/vouchers', 'AdminController@showVoucherPage');
    Route::post('/admin/vouchers/add', 'AdminController@addVoucher');
    Route::get('/admin/vouchers/delete/{id_voucher}', 'AdminController@deleteVoucher');

    /* User Account */
    Route::get('/admin/usersaccount', 'AdminAccountController@showUserAccountPage');
    Route::post('/admin/adminaccount/add', 'AdminAccountController@addAdminAccount');
    Route::get('/admin/adminaccount/delete/{username}', 'AdminAccountController@deleteAdminAccount');
    Route::post('/admin/adminaccount/getedit', 'AdminAccountController@getAdminData');
    Route::post('/admin/adminaccount/edit', 'AdminAccountController@editAdminAccount');

    /* Admin Account */
    Route::get('/admin/adminaccount', 'AdminAccountController@showAdminAccountPage');
    Route::post('/admin/adminaccount/add', 'AdminAccountController@addAdminAccount');
    Route::get('/admin/adminaccount/delete/{username}', 'AdminAccountController@deleteAdminAccount');
    Route::post('/admin/adminaccount/getedit', 'AdminAccountController@getAdminData');
    Route::post('/admin/adminaccount/edit', 'AdminAccountController@editAdminAccount');

    /* Admin Pesawat Airports */
    Route::get('/admin/pesawatairports', 'AdminStationController@showAirports');
    Route::post('/admin/pesawatairports/add', 'AdminStationController@storeAirport');
    Route::get('/admin/pesawatairports/getairport', 'AdminStationController@getAirport');
    Route::post('/admin/pesawatairports/edit', 'AdminStationController@editAirport');
    Route::get('/admin/pesawatairports/delete/{id_airport}', 'AdminStationController@airportDelete');

    /* Admin Pesawat Airlines */
    Route::get('/admin/pesawatairlines', 'AdminProviderController@showAirlines');
    Route::post('/admin/pesawatairlines/add', 'AdminProviderController@storeAirline');
    Route::get('/admin/pesawatairline/delete/{id_airline}', 'AdminProviderController@deleteAirline');
    Route::get('/admin/pesawatairline/restore/{iata_code}', 'AdminProviderController@restoreAirline');


    /* Admin Pesawat Aircrafts */
    Route::get('/admin/pesawataircrafts', 'AdminTransportsController@pesawataircrafts');
    Route::post('/admin/pesawataircrafts/add', 'AdminTransportsController@aircraftsadd');
    Route::post('/admin/pesawataircrafts/datafetching', 'AdminTransportsController@aircraftsdatafetching');
    Route::post('/admin/pesawataircrafts/edit', 'AdminTransportsController@aircraftsedit');
    Route::get('/admin/pesawataircrafts/delete/{aircrafts_registry}', 'AdminTransportsController@aircraftsdelete');

    /* Admin Pesawat Schedules */
    Route::get('/admin/pesawatschedules', 'Admin\Pesawat\ScheduleController@schedules');
    Route::post('/admin/pesawat/schedules', 'Admin\Pesawat\ScheduleController@store');
    Route::post('/admin/pesawatschedules/requiredfetching', 'AdminSchedulesController@requiredfetching');
    Route::post('/admin/pesawatschedules/datafetching', 'AdminSchedulesController@datafetching');
    Route::post('/admin/pesawatschedules/edit', 'AdminSchedulesController@schedulesedit');
    Route::get('/admin/pesawatschedules/delete/{id_schedule}', 'AdminSchedulesController@schedulesdelete');

    

    /* Pesawat flight */
    Route::get('/admin/pesawatflights', 'AdminFlightsController@pesawatFlights');
    Route::post('/admin/pesawatflights/add', 'AdminFlightsController@flightsadd');
    Route::post('/admin/pesawatflights/requiredfetching', 'AdminFlightsController@requiredfetching');
    Route::get('/admin/pesawatflights/delete/{flight_number}', 'AdminFlightsController@flightsdelete');

    
    /* Pesawat Tickets */
    Route::get('/admin/pesawattickets', 'AdminTicketsController@pesawattickets');
    Route::post('/admin/detailtickets', 'AdminTicketsController@pesawatDetailTickets');
    Route::get('/admin/getidtickets', 'AdminTicketsController@getIdTickets');
    Route::post('/admin/pesawattickets/add', 'AdminTicketsController@ticketsAdd');
    Route::post('/admin/pesawattickets/edit', 'AdminTicketsController@ticketsedit');
    Route::post('/admin/pesawattickets/delete', 'AdminTicketsController@ticketsdelete');


    /* Kereta Stations */
    Route::get('/admin/keretastations', 'AdminStationsController@keretastations');
    Route::post('/admin/keretastations/add', 'AdminStationsController@stationsadd');
    Route::post('/admin/keretastations/edit', 'AdminStationsController@stationedit');
    Route::get('/admin/keretastations/delete/{id_stations}', 'AdminStationsController@stationsdelete');

    /* Kereta Schedules */
    Route::get('/admin/keretaschedules', 'AdminSchedulesController@keretaschedules');
    Route::post('/admin/keretaschedules/add', 'AdminSchedulesController@keretaschedulesadd');
    Route::post('/admin/keretaschedules/edit', 'AdminSchedulesController@schedulesedit');
    Route::get('/admin/keretaschedules/delete/{id_schedule}', 'AdminSchedulesController@keretaschedulesdelete');

    /* Kereta Tickets */
    Route::get('/admin/keretatickets', 'AdminTicketsController@keretatickets');
    Route::post('/admin/keretadetailtickets', 'AdminTicketsController@keretaDetailTickets');
    Route::post('/admin/keretatickets/add', 'AdminTicketsController@keretaTicketsAdd'); 
    Route::post('/admin/keretaschedules/edit', 'AdminSchedulesController@schedulesedit');
    Route::get('/admin/keretaschedules/delete/{id_schedule}', 'AdminSchedulesController@keretaschedulesdelete');

    /* Kereta Trains */
    Route::get('/admin/keretatrains', 'AdminTransportsController@keretaTrains');
    Route::post('/admin/keretatrains/add', 'AdminTransportsController@trainsadd');
    Route::get('/admin/getkeretaidtickets', 'AdminTicketsController@getKeretaIdTickets');
    Route::get('/admin/keretatrains/delete/{trains_id}', 'AdminTransportsController@trainsdelete');


    
    });
    
    
    
//Email
Route::get('/sendmail/{order_key}/{order_id}', 'OrderController@sendmail');
Route::get('/keretasendmail/{order_key}/{order_id}', 'KeretaOrderController@sendmail');


//API
Route::post('/karcisregister', 'Authcontroller@registerRequest');
Route::get('/countdown', 'OrderController@countdown');
Route::post('/webapi/voucherclaim', 'OrderController@voucherClaim');
Route::get('/webapi/karcisvoucher', 'HomeController@getKarcisVoucher');
Route::get('/webapi/karcispoint', 'HomeController@getKarcisPoint');
Route::post('/webapi/checkvoucherclaimed', 'OrderController@isVoucherClaimed');
Route::get('/webapi/getchoosedticket', 'OrderController@getchooseticket');
Route::post('/webapi/setchooseticket', 'OrderController@setchooseticket');
Route::post('/webapi/searchticket', 'HomeController@ticketResult');
Route::get('/webapi/removechoosedticket', 'HomeController@removeChoosedTicket');


//Iseng
Route::get('/test', 'HomeController@ashiap');