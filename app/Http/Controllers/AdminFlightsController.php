<?php

namespace App\Http\Controllers;

use App\pesawat_airlines_model;
use App\pesawat_airports_model;
use App\pesawat_flights_model;
use Illuminate\Http\Request;

class AdminFlightsController extends Controller
{
    public function pesawatFlights(){
        $flights = pesawat_flights_model::with('airlineData')->get();

        $airlines = pesawat_airlines_model::all();
        $airports = pesawat_airports_model::all();

        return view('admin.pesawat.FlightsPage', [
            'flights' => $flights,
            'airlines' => $airlines,
            'airports' => $airports
        ]);
        
    }

    public function requiredfetching(Request $request){

        $airline_id = $request->airline_id;

        $airline = pesawat_airlines_model::with('flightsData')->where('airline_id', $airline_id)->first();

        return response($airline);

    }

    public function flightsadd(Request $request){

        $airline = $request->input('airline-flight');
        $iata_code = $request->input('iata-code-flight');
        $flight_number = $request->input('flight-number-flight');
        $airport_from = $request->input('airport-from-flight');
        $airport_to = $request->input('airport-to-flight');

        $flights = new pesawat_flights_model();
        $flights->flight_number = strtoupper($iata_code).'-'.$flight_number;
        $flights->airport_from = $airport_from;
        $flights->airport_to  = $airport_to;
        $flights->airline_id = $airline;
        
        try {
            $flights->save();

            return redirect('/admin/pesawatflights')->with(['Success' => 'Data berhasil di simpan']);
        } catch (\Throwable $th) {
            //throw $th;

            return redirect('/admin/pesawatflights')->with(['Error' => 'Data gagal di simpan']);

        }

    }
    
    public function flightsdelete($flight_number){
        $flights = pesawat_flights_model::where('flight_number', $flight_number);

        if ($flights->delete()) {

            return redirect('/admin/pesawatflights')->with(['Success' => 'Data Berhasil di hapus']);

        }else{

            return redirect('/admin/pesawatflights')->with(['Error' => 'Data gagal di hapus']);

        }
    }
}
