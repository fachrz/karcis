<?php

namespace App\Http\Controllers\Admin\Pesawat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\pesawat_airlines_model;
use App\pesawat_schedules_model;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function schedules()
    { 
        $now = Carbon::now()->toDateTimeString();
        $schedules = pesawat_schedules_model::with('flightData')->where('departure_date','>=', $now)->get();
        $airlines = pesawat_airlines_model::select('airline_id', 'airline_name')->get();

        return view('Admin.Pesawat.SchedulesPage', compact('schedules', 'airlines')); 
    }

    //butuh form validation
    public function store(Request $request)
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

        try {
            $schedule->save();
            return redirect('/admin/pesawatschedules')->with(['Success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $e) {
            return redirect('/admin/pesawatschedules')->with(['Error' => 'Data gagal ditambahkan'.$e]);

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
}
