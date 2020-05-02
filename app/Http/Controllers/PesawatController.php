<?php

namespace App\Http\Controllers;

use App\PesawatAirport;
use Illuminate\Http\Request;

class PesawatController extends Controller
{
    /**
     * Show pesawat searchpage
     * 
     */
    public function showHomePage()
    {   
        $airports = PesawatAirport::all();
    
        return \view('Pesawat.HomePage', compact('airports'));
    }
}
