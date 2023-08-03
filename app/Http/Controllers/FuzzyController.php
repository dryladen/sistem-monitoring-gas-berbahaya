<?php

namespace App\Http\Controllers;

use App\Models\AturanFuzzy;
use App\Models\DataFuzzy;
use App\Models\DataGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuzzyController extends Controller
{
    private $derajatKeanggotaan;
    public function index()
    {
        $data = array(
            "title" => "Himpunan Fuzzy",
            "data_fuzzy" => DataFuzzy::join("tbl_variabel_fuzzy", "tbl_variabel_fuzzy.id", "=", "tbl_range_fuzzy.id")->select("tbl_range_fuzzy.*", "tbl_variabel_fuzzy.variabel")->get(),
            "derajat_keanggotaan" => $this->derajatKeanggotaan(19, 53),
            "aturan_fuzzy" => AturanFuzzy::all(),
            "alpa_predikat" => $this->fungsiImplikasi(),
        );
        return view('fuzzy', $data);
    }

    // ! Fuzifikasi
    // Fungsi keanggotaan segitiga
    private function fSegitiga($x, $a, $b, $c)
    {
        if ($x <= $a || $x >= $c) {
            return 0;
        } elseif ($x >= $b && $x <= $c) {
            return ($c - $x) / ($c - $b);
        } elseif ($x >= $a && $x <= $b) {
            return ($x - $a) / ($b - $a);
        } else {
            return 1;
        }
    }

    // Fungsi keanggotaan linear naik
    private function fLinearNaik($x, $a, $b)
    {
        if ($x <= $a) {
            return 0;
        } elseif ($x >= $b) {
            return 1;
        } else {
            return ($x - $a) / ($b - $a);
        }
    }

    // Fungsi keanggotaan linear turun
    private function fLinearTurun($x, $a, $b)
    {
        if ($x <= $a) {
            return 1;
        } elseif ($x >= $b) {
            return 0;
        } else {
            return ($b - $x) / ($b - $a);
        }
    }

    // ! Fungsi Implikasi
    private function derajatKeanggotaan($x1, $x2)
    {
        $dataFuzzy = DataFuzzy::all();
        $this->derajatKeanggotaan = array(
            "Amonia" => array(
                "Rendah" => $this->fSegitiga($x1, $dataFuzzy[0]["a"], $dataFuzzy[0]["b"], $dataFuzzy[0]["c"]),
                "Normal" => $this->fSegitiga($x1, $dataFuzzy[1]["a"], $dataFuzzy[1]["b"], $dataFuzzy[1]["c"]),
                "Tinggi" => $this->fSegitiga($x1, $dataFuzzy[2]["a"], $dataFuzzy[2]["b"], $dataFuzzy[2]["c"]),
            ),
            "Metana" => array(
                "Rendah" => $this->fLinearTurun($x2, $dataFuzzy[3]["a"], $dataFuzzy[3]["b"]),
                "Normal" => $this->fSegitiga($x2, $dataFuzzy[4]["a"], $dataFuzzy[4]["b"], $dataFuzzy[4]["c"]),
                "Tinggi" => $this->fLinearNaik($x2, $dataFuzzy[5]["a"], $dataFuzzy[5]["b"]),
            )
        );
        return $this->derajatKeanggotaan;
    }

    private function fungsiImplikasi(){
        $aturanFuzzy = DB::table("tbl_aturan_fuzzy")->get();
        $alpa_predikat = array();
        foreach ($aturanFuzzy as $item){
            array_push($alpa_predikat,min($this->derajatKeanggotaan["Amonia"][$item->variabel1],$this->derajatKeanggotaan["Metana"][$item->variabel2]));
        }
        return $alpa_predikat;
    }
}
