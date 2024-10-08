<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemainMU extends Controller
{
    public function index (){
        $data_pemain = pemainmu::all();
        // Kirim data ke view
        return view('pemainmu', compact('data_pemain'));

    }


}
