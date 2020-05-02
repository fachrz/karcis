<?php

namespace App\Http\Controllers;

use App\kereta_stations_model;
use App\pesawat_airports_model;
use App\PesawatAirport;
use Illuminate\Http\Request;

class AdminStationsController extends Controller
{
    /**
     * Pesawat
     * 
     */
    public function showAirports(){

        $airports = PesawatAirport::all();
        
        return view('Admin.Pesawat.PesawatAirportsPage', compact('airports'));
    }
    
    public function airportadd(Request $request){
        $id_airport = strtoupper($request->input('id-airport'));
        $airport_name = ucfirst($request->input('airport-name'));
        $location = ucfirst($request->input('location'));
        $province = ucfirst($request->input('province'));

        $airport = new pesawat_airports_model();
        $airport->id_airport = $id_airport;
        $airport->airport_name = $airport_name;
        $airport->location = $location;
        $airport->province = $province;
        
        if ($airport->save()) {
            return redirect('/admin/pesawatairports')->with(['Success' => 'Data berhasil ditambahkan']);
        }else{
            return redirect('/admin/pesawatairports')->with(['Error' => 'Data gagal ditambahkan']);
        }
    }

    public function airportedit(Request $request){
        $id_airport = strtoupper($request->input('id-airport'));
        $airport_name = ucfirst($request->input('airport-name'));
        $location = ucfirst($request->input('location'));
        $province = ucfirst($request->input('province'));

        try {
            $airport = pesawat_airports_model::where('id_airport', $id_airport);
            $airport->update([

                'airport_name' => $airport_name,
                'location' => $location,
                'province' => $province,

            ]);

            return redirect('/admin/pesawatairports')->with(['Success' => 'Update Berhasil']);

        } catch (\Exception $th) {
            return redirect('/admin/pesawatairports')->with(['Error' => 'Update Gagal']);
        }
    }

    public function airportDelete($id_airport){
        $airport = PesawatAirport::find($id_airport);
        $airport->delete();
        
        if ($airport->delete()) {
            return redirect()->back()->with(['Error' => 'Data berhasil di hapus']);
        }else {
            return redirect()->back()->with(['Error' => 'Data gagal di hapus']);
        }
    }

    public function airportsdatafetching(Request $request){
        $id_airport = $request->id_airports;
        $airport = pesawat_airports_model::where('id_airport', $id_airport)->first();
        return response($airport);
    }

    /**
     * Kereta Controller
     */
    public function keretastations(){
        $stations = kereta_stations_model::all();
        return view('admin.kereta.KeretaStationsPage', [
            'stations' => $stations,
        ]);
    }

    public function stationsadd(Request $request){

        $id_station = $request->input('id-station');
        $station_name = $request->input('station-name');
        $location   = $request->input('location');
        $province = $request->input('province');

        $stations = new kereta_stations_model();
        $stations->id_station = $id_station;
        $stations->station_name = $station_name;
        $stations->location = $location;
        $stations->province = $province;

        try {
            $stations->save();

            return redirect('admin/keretastations')->with(['Success' => 'Data Berhasil di insert']);
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
            return redirect('admin/keretastations')->with(['Error' => 'Data gagal di Insert']);
        }

    }

    public function stationsdelete($id_stations){

        $stations = kereta_stations_model::where('id_station', $id_stations);
        if ($stations->delete()) {
            return redirect('/admin/keretastations')->with(['Success' => 'Data Berhasil di hapus']);
        }else{
            return redirect('/admin/keretastations')->with(['Error' => 'Data gagal di hapus']);
        }

    }
}
