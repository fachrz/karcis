<?php

namespace App\Http\Controllers;

use App\kereta_stations_model;
use App\PesawatAirport;
use Illuminate\Http\Request;

class AdminStationController extends Controller
{
    /**
     * Show Pesawat Airports data
     * 
     * @return View PesawatAirportsPage
     */
    public function showAirports()
    {
        $airports = PesawatAirport::all();
        
        return view('Admin.Pesawat.PesawatAirportsPage', compact('airports'));
    }
    
    /**
     * Store Airport data
     * 
     * @param Request $request
     */
    public function storeAirport(Request $request)
    {
        $id_airport = strtoupper($request->input('id-airport'));
        $airport_name = ucfirst($request->input('airport-name'));
        $location = ucfirst($request->input('location'));
        $province = ucfirst($request->input('province'));

        $airport = PesawatAirport::withTrashed()->updateOrCreate(
            ['id_airport' => $id_airport],
            [
                'airport_name' => $airport_name,
                'location' => $location,
                'province' => $province
            ]
        )->restore();

        
        if ($airport) {
            return redirect()->back()->with(['Success' => 'Data berhasil ditambahkan']);
        }else{
            return redirect()->back()->with(['Error' => 'Data gagal ditambahkan']);
        }
    }

    /**
     * Delete Airport data
     * 
     * @param String $id_airport
     * @return RedirectResponse
     */
    public function airportDelete($id_airport)
    {
        $airport = PesawatAirport::find($id_airport);
        
        if ($airport->delete()) {
            return redirect()->back()->with(['Error' => 'Data berhasil di hapus']);
        }else {
            return redirect()->back()->with(['Error' => 'Data gagal di hapus']);
        }
    }

    /**
     * Edit Airport data
     * 
     * @param Request $request
     * @return RedirectResponse
     */
    public function editAirport(Request $request)
    {
        $id_airport = strtoupper($request->input('id-airport'));
        $airport_name = ucfirst($request->input('airport-name'));
        $location = ucfirst($request->input('location'));
        $province = ucfirst($request->input('province'));

        try {
            $airport = PesawatAirport::where('id_airport', $id_airport);
            $airport->update([
                'airport_name' => $airport_name,
                'location' => $location,
                'province' => $province,
            ]);

            return redirect()->back()->with(['Success' => 'Update Berhasil']);
        } catch (\Exception $th) {
            return redirect()->back()->with(['Error' => 'Update Gagal']);
        }
    }
    
    /**
     * Get Airport data and return in JSON
     * 
     * @param Request $request
     * @return Json airport data
     */
    public function getAirport(Request $request)
    {
        $airport = PesawatAirport::where('id_airport', $request->id_airport)->first();
        
        return response($airport);
    }

    /**
     * Kereta
     * 
     * @return View KeretaStationsPage
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
