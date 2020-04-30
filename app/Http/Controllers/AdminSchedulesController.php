<?php

namespace App\Http\Controllers;

use App\kereta_schedules_model;
use App\kereta_stations_model;
use App\kereta_trains_model;
use App\pesawat_aircrafts_model;
use App\pesawat_airlines_model;
use App\pesawat_schedules_model;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminSchedulesController extends Controller
{
    public function pesawatSchedules()
    { 
        $now = Carbon::now()->toDateTimeString();
        $schedules = pesawat_schedules_model::with('flightData', 'ticketData')->where('departure_date','>=', $now)->get();
        $airlines = pesawat_airlines_model::select('airline_id', 'airline_name')->get();

        return view('admin.PesawatSchedulesPage', compact('schedules', 'airlines')); 
    }

    public function schedulesadd(Request $request)
    {
        $aircraft_registry = $request->input('aircraft-registry');
        $flight_number = $request->input('flight-number');
        $departure_date = $request->input('departure-date');
        $economy_quota = $request->input('economy-quota');
        $premeconomy_quota = $request->input('premeconomy-quota');
        $bussiness_quota = $request->input('bussiness-quota');
        $first_quota = $request->input('first-quota');

        $schedule = new pesawat_schedules_model();
        $schedule->aircraft_registry = $aircraft_registry;
        $schedule->flight_number = $flight_number;
        $schedule->departure_date = $departure_date;
        $schedule->economy_quota = $economy_quota;
        $schedule->premeconomy_quota = $premeconomy_quota;
        $schedule->bussiness_quota = $bussiness_quota;
        $schedule->first_quota = $first_quota;

        try {

            $schedule->save();
            return redirect('/admin/pesawatschedules')->with(['Success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $e) {
            return redirect('/admin/pesawatschedules')->with(['Error' => 'Data gagal ditambahkan']);

        }  
    }

    public function schedulesdelete($id_schedule){

        $schedule = pesawat_schedules_model::where('id_schedule', $id_schedule);

        if ($schedule->delete()) {

            return redirect('/admin/pesawatschedules')->with(['Success' => 'Data Berhasil di hapus']);

        }else{

            return redirect('/admin/pesawatschedules')->with(['Error' => 'Data gagal di hapus']);

        }
    }

    public function requiredfetching(Request $request){
        $airline_id = $request->airline_id;

        $airline = pesawat_airlines_model::with('aircraftsData', 'flightsData')->where('airline_id', $airline_id)->first();

        return response($airline);

    }

    public function datafetching(Request $request){
        
        $schedule_id = $request->id_schedule;

        $schedules = pesawat_schedules_model::with('pesawat_aircrafts')->where('id_schedule', $schedule_id)->first();

        $airline_id = $schedules->pesawat_aircrafts->airline_id;
        $airline = pesawat_airlines_model::with('aircraftsData', 'flightsData')->where('airline_id', $airline_id)->first();


        return response([
            'schedule' => $schedules,
            'airline' => $airline
        ]);
    }

    public function schedulesedit(Request $request){
        
        $id_schedule = $request->input('id-schedule');
        $aircraft_registry = $request->input('aircraft-registry');
        $flight_number = $request->input('flight-number');
        $departure_date = $request->input('departure-date');
        $economy_quota = $request->input('economy-quota');
        $premeconomy_quota = $request->input('premeconomy-quota');
        $bussiness_quota = $request->input('bussiness-quota');
        $first_quota = $request->input('first-quota');

        try {
            $schedule = pesawat_schedules_model::where('id_schedule', $id_schedule);
            $schedule->update([

                'aircraft_registry' => $aircraft_registry,
                'flight_number' => $flight_number,
                'departure_date' => $departure_date,
                'economy_quota' => $economy_quota,
                'premeconomy_quota' => $premeconomy_quota,
                'bussiness_quota' => $bussiness_quota,
                'first_quota' => $first_quota,

            ]);

            return redirect('/admin/pesawatschedules')->with(['Success' => 'Berhasil menyimpan perubahan']);

        } catch (\Exception $e) {
            return redirect('/admin/pesawatschedules')->with(['Error' => 'Gagal menyimpan perubahan']);

        }  
    }

    /**
     * Kereta
     */

    public function keretaschedules(){

        $now = Carbon::now()->toDateTimeString();

        $schedules = kereta_schedules_model::where('departure_date','>=', $now)
        ->get(); //Schedule yang akan datang saja

        $stations = kereta_stations_model::all();
        $trains = kereta_trains_model::all();
        
        return view('admin.kereta.KeretaSchedulesPage', [
            'schedules' => $schedules,
            'stations' => $stations,
            'trains' => $trains
        ]); 

    }

    public function keretaschedulesadd(Request $request){

        
        $from = $request->input('station-from');
        $to = $request->input('station-to');
        $train = $request->input('kereta-train');
        $departure_date = $request->input('departure-date');

        $schedules = new kereta_schedules_model();
        $schedules->station_from = $from;
        $schedules->station_to = $to;
        $schedules->train_id = $train;
        $schedules->departure_date = $departure_date;
        

        try {
            
            $schedules->save();

            return redirect('/admin/keretaschedules')->with(['Success' => 'Data berhasil di simpan']);

        } catch (\Throwable $th) {
            
            //throw $th;
            return redirect('/admin/keretaschedules')->with(['Error' => 'Data gagal di simpan']);

        }

    }

    public function keretaschedulesdelete($id_schedule){

        $schedule = kereta_schedules_model::where('id_schedule', $id_schedule);

        if ($schedule->delete()) {

            return redirect('/admin/keretaschedules')->with(['Success' => 'Data Berhasil di hapus']);

        }else{

            return redirect('/admin/keretaschedules')->with(['Error' => 'Data gagal di hapus']);

        }

    }

}
