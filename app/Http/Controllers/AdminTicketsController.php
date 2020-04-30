<?php

namespace App\Http\Controllers;

use App\kereta_schedules_model;
use App\kereta_tickets_model;
use App\pesawat_schedules_model;
use App\pesawat_tickets_model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTicketsController extends Controller 
{
    public function pesawattickets(){
        $departuredate = Carbon::now()->toDateTimeString();
        $tickets = pesawat_tickets_model::with('pesawat_schedules')->whereHas('pesawat_schedules', function ($clause) use($departuredate){
                $clause->whereDate('departure_date', '>=', $departuredate);
        })->get();

        $schedules = pesawat_schedules_model::with('flightData')->whereDate('departure_date','>=', $departuredate)->get();
    
        return view('Admin.Pesawat.TicketsPage', [
            'tickets' => $tickets,  
            'schedules' => $schedules
        ]);
    }

    public function pesawatDetailTickets(Request $request)
    {
        $tickets = pesawat_tickets_model::with('pesawat_schedules')->where('id_ticket', $request->id_ticket)->first();

        return response([
            'dataTiket' => $tickets
        ]);
    }

    public function ticketsadd(Request $request){
        $id_ticket = strtoupper($request->input('id-tickets'));
        $id_schedule = $request->input('id-schedule');
        if (empty($id_schedule)) {
            return redirect('/admin/pesawattickets')->with(['Error' => 'Jadwal tidak boleh kosong']);
        }
        $seat_class = $request->input('seat-class');
        $price = $request->input('price');

        $ticketExist = pesawat_tickets_model::where([
            ['id_schedule', $id_schedule],
            ['seat_class', $seat_class]
        ])->exists();

        if ($ticketExist == true) {

            return redirect()->back()->with(['Error' => 'Ticket yang sama sudah terdaftar']);

        }else {

            $tickets = new pesawat_tickets_model();
            $tickets->id_ticket = $id_ticket;
            $tickets->id_schedule = $id_schedule;
            $tickets->seat_class = $seat_class;
            $tickets->karcis_point = $request->input('karcis-point');
            $tickets->price = $price;
            $tickets->economy_quota = $request->input('economy-quota');
            $tickets->premeconomy_quota = $request->input('premeconomy-quota');
            $tickets->bussiness_quota = $request->input('bussiness-quota');
            $tickets->first_quota = $request->input('first-quota');
           

            try {
                $tickets->save();
                return redirect('/admin/pesawattickets')->with(['Success' => 'Data berhasil ditambahkan']);
    
            } catch (\Exception $e) {
                return redirect('/admin/pesawattickets')->with(['Error' => 'Data gagal ditambahkan'.$e]);
            }

        }

     
        
        
    }

    public function getIdTickets()
    {
        $ticket = pesawat_tickets_model::select('id_ticket')->orderBy('id_ticket', 'desc')->first();

        $getid = explode('0', $ticket->id_ticket);
        $incrementing = $getid[1] + 1;

        $id_ticket = 'KRC0'.$incrementing;

        return response([
            'id_ticket' => $id_ticket
        ]);
    }

    /**
     * Kereta
     * 
     */

    public function keretatickets(){
        $departuredate = Carbon::now()->toDateTimeString();
        $tickets = kereta_tickets_model::with('scheduleData')->whereHas('scheduleData', function ($clause) use($departuredate){
                $clause->whereDate('departure_date', '>=', $departuredate);
        })->get();

        $schedules = kereta_schedules_model::whereDate('departure_date','>=', $departuredate)->get();

        return view('Admin.Kereta.TicketsPage', [
            'tickets' => $tickets,  
            'schedules' => $schedules
        ]);
    }

    public function getKeretaIdTickets()
    {
        $ticket = kereta_tickets_model::select('id_ticket')->orderBy('id_ticket', 'desc')->first();

        $getid = explode('0', $ticket->id_ticket);
        $incrementing = $getid[1] + 1;

        $id_ticket = 'KRC0'.$incrementing;

        return response([
            'id_ticket' => $id_ticket
        ]);
    }

    public function keretaDetailTickets(Request $request)
    {
        $tickets = kereta_tickets_model::with('scheduleData')->where('id_ticket', $request->id_ticket)->first();

        return response([
            'dataTiket' => $tickets
        ]);
    }

    public function keretaTicketsAdd(Request $request){
        $id_ticket = strtoupper($request->input('id-tickets'));
        $id_schedule = $request->input('id-schedule');
        if (empty($id_schedule)) {
            return redirect('/admin/keretatickets')->with(['Error' => 'Jadwal tidak boleh kosong']);
        }
        $seat_class = $request->input('seat-class');
        $price = $request->input('price');

        $tickets = new kereta_tickets_model();
        $tickets->id_ticket = $id_ticket;
        $tickets->id_schedule = $id_schedule;
        $tickets->seat_class = $seat_class;
        $tickets->price = $price;
        $tickets->economy_quota = $request->input('economy-quota');
        $tickets->bussiness_quota = $request->input('bussiness-quota');
        $tickets->executive_quota = $request->input('executive-quota');
        
        try {

            $tickets->save();
            return redirect()->back()->with(['Success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $e) {

            return redirect()->back()->with(['Error' => 'Data gagal ditambahkan'.$e]);
            
        }
    }
}
