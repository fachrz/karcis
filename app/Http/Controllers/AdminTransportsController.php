<?php

namespace App\Http\Controllers;

use App\kereta_trains_model;
use App\pesawat_aircrafts_model;
use App\pesawat_airlines_model;
use App\pesawat_schedules_model;
use Illuminate\Http\Request;

class AdminTransportsController extends Controller
{
    /**
     * Pesawat
     */
    public function pesawataircrafts(){

        $aircrafts = pesawat_aircrafts_model::with('airlinesData')->get();

        $airlines = pesawat_airlines_model::select('airline_id', 'airline_name')->get();

        return view('admin.pesawat.PesawatAircraftsPage', [
            'aircrafts' => $aircrafts,
            'airlines' => $airlines 
        ]);

    }
    
    public function aircraftsadd(Request $request){

        $aircraft_registry = strtoupper($request->input('aircraft-registry'));
        $airline_id = ucfirst($request->input('airline-id'));
        $nationality = ucfirst($request->input('nationality'));
        $aircraft_model = ucfirst($request->input('aircraft-model'));

        if ($airline_id == 0) {

            return redirect('/admin/pesawataircrafts')->with(['Error' => 'Data gagal ditambahkan, isi column maskapai']);

        }

        $aircraft = new pesawat_aircrafts_model();
        $aircraft->aircraft_registry = $aircraft_registry;
        $aircraft->airline_id = $airline_id;
        $aircraft->nationality = $nationality;
        $aircraft->aircraft_model = $aircraft_model;
        
        if ($aircraft->save()) {

            return redirect('/admin/pesawataircrafts')->with(['Success' => 'Data berhasil ditambahkan']);

        }else{

            return redirect('/admin/pesawatairport')->with(['Error' => 'Data gagal ditambahkan']);

        }
    }
    
    public function aircraftsdelete($aircraft_registry){

        $schedule = pesawat_aircrafts_model::where('aircraft_registry', $aircraft_registry);

        if ($schedule->delete()) {

            return redirect('/admin/pesawataircrafts')->with(['Success' => 'Data Berhasil di hapus']);

        }else{

            return redirect('/admin/pesawataircrafts')->with(['Error' => 'Data gagal di hapus']);
        }
    }

    public function aircraftsdatafetching(Request $request){

        $aircraft_registry = $request->aircraft_registry;

        $aircraft = pesawat_aircrafts_model::where('aircraft_registry', $aircraft_registry)->first();

        $airlines = pesawat_airlines_model::select('airline_id', 'airline_name')->get();

        return response([
            'aircraft' => $aircraft,
            'airlines' => $airlines
        ]);

    }

    public function aircraftsedit(Request $request){

        $aircraft_registry = strtoupper($request->input('aircraft-registry'));
        $airline_id = ucfirst($request->input('airline-id'));
        $nationality = ucfirst($request->input('nationality'));
        $aircraft_model = ucfirst($request->input('aircraft-model'));

        try {

            $aircraft = pesawat_aircrafts_model::where('aircraft_registry', $aircraft_registry);
            $aircraft->update([

                'airline_id' => $airline_id,
                'nationality' => $nationality,
                'aircraft_model' => $aircraft_model,

            ]);

            return redirect('/admin/pesawataircrafts')->with(['Success' => 'Update Berhasil']);

        } catch (\Exception $th) {
            
            return $th;
            return redirect('/admin/pesawataircrafts')->with(['Error' => 'Update Gagal']);

        }

    }

    /**
     * Kereta
     */
    
    public function keretatrains(){

        $trains = kereta_trains_model::all();

        return view('admin.kereta.KeretaTrainsPage', [
            'trains' => $trains,
        ]);


    }
    public function trainsadd(Request $request){

        $train_id = $request->input('train-id');
        $train_name = $request->input('train-name');
        $trains = new kereta_trains_model;
        $trains->train_id = $train_id;
        $trains->train_name = $train_name;

        try {
            
            $trains->save();

            return redirect('/admin/keretatrains')->with(['Success' => 'Data berhasil di simpan']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/admin/keretatrains')->with(['Error' => 'Data gagal di simpan']);

        }


    }


    public function trainsdelete($trains_id){

        $trains = kereta_trains_model::where('train_id', $trains_id);

        if ($trains->delete()) {

            return redirect('/admin/keretatrains')->with(['Success' => 'Data Berhasil di hapus']);

        }else{

            return redirect('/admin/keretatrains')->with(['Error' => 'Data gagal di hapus']);
        }

    }

}
