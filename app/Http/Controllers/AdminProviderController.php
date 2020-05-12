<?php

namespace App\Http\Controllers;

use App\PesawatAirline;
use Illuminate\Http\Request;

class AdminProviderController extends Controller
{
    /**
     * Show Pesawat Airline Page
     * 
     * @return View PesawatAirlinesPage
     */
    public function showAirlines(){
        $airlines = PesawatAirline::all();
        
        return view('admin.pesawat.PesawatAirlinesPage', compact('airlines'));
    }

    /**
     * Store Airline data
     * 
     * @param Request $requst
     * @return RedirectResponse
     */
    public function storeAirline(Request $request){
        $airline_name = ucwords($request->input('airline-name'));
        $iata_code = strtoupper($request->input('iata-code'));
        $icao_code   = strtoupper($request->input('icao-code'));
        $airline_logo = $request->file('airline-logo');
        $etiket_logo = $request->file('eticket-logo');

        $findDeletedAirline = $this->findDeletedAirline($iata_code);

        if ($findDeletedAirline) {
            return redirect()->back()->with([
                'trashedAirline' => 'Maskapai dengan Kode IATA yang sama telah dihapus!!',
                'id_airline' => $findDeletedAirline
            ]);
        }else {
            $tujuan_upload = public_path('/images/airlines');
            $airline_logo->move($tujuan_upload, $airline_logo->getClientOriginalName());
            $etiket_logo->move(public_path('/images/eticket'), $etiket_logo->getClientOriginalName());

            $airlines = new PesawatAirline();
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
    }

    /**
     * Delete Airline
     * 
     * @param int $id_airline
     * @return RedirectResponse
     */
    public function deleteAirline($id_airline){
        $airline = PesawatAirline::find($id_airline);
        
        if ($airline->delete()) {
            return redirect()->back()->with(['Success' => 'Data berhasil di hapus']);
        }else {
            return redirect()->back()->with(['Error' => 'Data gagal di hapus']);
        }
    }

    /**
     * Find Deleted Airline first before insert
     * 
     * @param String $iata_code
     * @return String|null $iata_code
     */
    public function findDeletedAirline($iata_code)
    {
        $trashedAirline = PesawatAirline::withTrashed()->where('iata_code', $iata_code)->first('iata_code');

        $iata_code = $trashedAirline->iata_code;

        return $iata_code;
    }

    /**
     * Restore Airline
     * 
     * @param String $iata_code
     * @return RedirectResponse
     */
    public function restoreAirline($iata_code)
    {
        PesawatAirline::withTrashed()->where('iata_code', $iata_code)->restore();

        return redirect()->back()->with(['Success' => 'Data berhasil di kembalikan']);
    }
}
