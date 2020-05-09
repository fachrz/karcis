<?php

namespace App\Http\Controllers;

use App\pesawat_airlines_model;
use App\PesawatAirline;
use Illuminate\Http\Request;

class AdminProviderController extends Controller
{
    public function showAirline(){
        $airlines = PesawatAirline::all();
        
        return view('admin.pesawat.PesawatAirlinesPage', compact('airlines'));
    }

    public function storeAirline(Request $request){
        $airline_name = ucwords($request->input('airline-name'));
        $iata_code = strtoupper($request->input('iata-code'));
        $icao_code   = strtoupper($request->input('icao-code'));
        $airline_logo = $request->file('airline-logo');
        $etiket_logo = $request->file('eticket-logo');

        $tujuan_upload = public_path('/images/airlines');
        $airline_logo->move($tujuan_upload, $airline_logo->getClientOriginalName());
        $etiket_logo->move(public_path('/images/eticket'), $etiket_logo->getClientOriginalName());

        $airlines = new pesawat_airlines_model();
        $airlines->airline_name = $airline_name;
        $airlines->iata_code = $iata_code;
        $airlines->icao_code = $icao_code;
        $airlines->airline_logo = '/images/airlines/'.$airline_logo->getClientOriginalName();
        $airlines->etiket_logo = '/images/eticket/'.$etiket_logo->getClientOriginalName();
        
        
        try {
            $airlines->save();

            return redirect('/admin/pesawatairlines')->with(['Success' => 'Data berhasil ditambahkan']);

        } catch (\Exception $th) {
            throw $th;
            return redirect('/admin/pesawatairlines')->with(['Error' => 'Data gagal ditambahkan']);
        }
    }

    public function deleteAirline($id_airline){
        $airlines = PesawatAirline::withTrashed()->find($id_airline)->restore();

        // if ($airlines->delete()) {
        //     return redirect('/admin/pesawatairlines')->with(['Success' => 'Data Berhasil di hapus']);
        // }else{
        //     return redirect('/admin/pesawatairlines')->with(['Error' => 'Data gagal di hapus']);
        // }
    }
}
