<?php

namespace App\Http\Controllers;

use App\kereta_stations_model;
use App\kereta_tickets_model;
use Illuminate\Http\Request;

class KeretaController extends Controller
{
    public function index(){
        $stations = kereta_stations_model::all();
        return view('kereta.HomePage', [
            'stations' => $stations
        ]);
    }

    public function searchResult(Request $request)
    {  
        $departure = $request->d; 
        $arrival = $request->a;
        $departuredate = $request->dd;
        $class = $request->class;

        $ticketresult = kereta_tickets_model::with('scheduleData.trainData', 'scheduleData.stationFromData', 'scheduleData.stationToData')->where('seat_class', $class)->
            whereHas('scheduleData', function ($clause) use($departure, $arrival, $departuredate){
                $clause->where([
                    ['station_from','=', $departure],
                    ['station_to','=', $arrival],
                ])->whereDate('departure_date', '=', $departuredate);
            })->get();

        return \view('kereta.ResultPage', [
            'tiketresult' => $ticketresult
        ]);
    }
}
