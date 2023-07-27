<?php

namespace App\Http\Controllers;

use App\Models\DataGas;
use Illuminate\Http\Request;

class FuzzyController extends Controller
{
    public function index(){
        $data = array(
            "title" => "Riwayat Monitoring",
            "data_gas" => DataGas::all(),
        );
        return view('riwayat_monitoring',$data);
    }
}
