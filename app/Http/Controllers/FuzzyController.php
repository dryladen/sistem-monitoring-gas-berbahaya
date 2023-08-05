<?php

namespace App\Http\Controllers;

use App\Models\AturanFuzzy;
use App\Models\DataFuzzy;
use App\Models\DataGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuzzyController extends Controller
{
    private $derajat_keanggotaan;
    private $alpa_predikat;
    private $komposisi_aturan;
    private $komposisi_tertinggi;
    private $nilai_keanggotaan;
    public function index()
    {
        $data = array(
            "title" => "Himpunan Fuzzy",
            "data_fuzzy" => DataFuzzy::join("tbl_variabel_fuzzy", "tbl_variabel_fuzzy.id", "=", "tbl_range_fuzzy.id")->select("tbl_range_fuzzy.*", "tbl_variabel_fuzzy.variabel")->get(),
            "derajat_keanggotaan" => $this->derajat_keanggotaan(14, 45),
            "aturan_fuzzy" => AturanFuzzy::all(),
            "alpa_predikat" => $this->fungsiImplikasi(),
            "komposisi_aturan" => $this->komposisiAturan(),
            "nilai_keanggotaan" => $this->nilaiKeanggotaan(),
            "deffuzifikasi" => $this->deffuzifikasi()
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
    private function derajat_keanggotaan($x1, $x2)
    {
        $dataFuzzy = DataFuzzy::all();
        $this->derajat_keanggotaan = array(
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
        return $this->derajat_keanggotaan;
    }

    private function fungsiImplikasi()
    {
        $aturanFuzzy = DB::table("tbl_aturan_fuzzy")->get();
        $this->alpa_predikat = array();
        foreach ($aturanFuzzy as $item) {
            array_push($this->alpa_predikat, min($this->derajat_keanggotaan["Amonia"][$item->variabel1], $this->derajat_keanggotaan["Metana"][$item->variabel2]));
        }
        return $this->alpa_predikat;
    }

    private function komposisiAturan()
    {
        $this->komposisi_aturan = array();
        array_push($this->komposisi_aturan, max($this->alpa_predikat[0], $this->alpa_predikat[1], $this->alpa_predikat[3]));
        array_push($this->komposisi_aturan, max($this->alpa_predikat[2], $this->alpa_predikat[4], $this->alpa_predikat[5]));
        array_push($this->komposisi_aturan, max($this->alpa_predikat[6], $this->alpa_predikat[7], $this->alpa_predikat[8]));

        if ($this->komposisi_aturan[0] > $this->komposisi_aturan[1] && $this->komposisi_aturan[0] > $this->komposisi_aturan[2]) {
            $this->komposisi_tertinggi = [0 => "Aman"];
        } else if ($this->komposisi_aturan[1] > $this->komposisi_aturan[0] && $this->komposisi_aturan[1] > $this->komposisi_aturan[2]) {
            $this->komposisi_tertinggi = [0 => "Waspada"];
        } else if ($this->komposisi_aturan[2] > $this->komposisi_aturan[0] && $this->komposisi_aturan[2] > $this->komposisi_aturan[1]) {
            $this->komposisi_tertinggi = [0 => "Bahaya"];
        }
        return $this->komposisi_aturan;
    }

    private function nilaiKeanggotaan()
    {
        $variabel_fuzzy = DB::table('tbl_range_fuzzy')->get();
        $a1 = 0;
        $a2 = 0;
        if ($this->komposisi_tertinggi[0] == "Aman") {
            $a1 = $variabel_fuzzy[6]->a  + ($this->komposisi_aturan[0] * ($variabel_fuzzy[6]->b - $variabel_fuzzy[6]->a));
            $a2 = $variabel_fuzzy[6]->c  - ($this->komposisi_aturan[0] * ($variabel_fuzzy[6]->c - $variabel_fuzzy[6]->b));
        } else if ($this->komposisi_tertinggi[0] == "Waspada") {
            $a1 = $variabel_fuzzy[7]->a  + ($this->komposisi_aturan[1] * ($variabel_fuzzy[7]->b - $variabel_fuzzy[7]->a));
            $a2 = $variabel_fuzzy[7]->c  - ($this->komposisi_aturan[1] * ($variabel_fuzzy[7]->c - $variabel_fuzzy[7]->b));
        } else if ($this->komposisi_tertinggi[0] == "Bahaya") {
            $a1 = $variabel_fuzzy[8]->a  + ($this->komposisi_aturan[1] * ($variabel_fuzzy[8]->b - $variabel_fuzzy[8]->a));
            $a2 = $variabel_fuzzy[8]->c  - ($this->komposisi_aturan[1] * ($variabel_fuzzy[8]->c - $variabel_fuzzy[8]->b));
        };
        $this->nilai_keanggotaan = ["a1" => $a1, "a2" => $a2];
        return $this->nilai_keanggotaan;
    }

    private function deffuzifikasi(){
        $a1 = $this->nilai_keanggotaan["a1"];
        $a2 = $this->nilai_keanggotaan["a2"];
        $output = ((($a1-$a2+1)*($a1+$a2))/2)/($a1-$a2+1);
        if ($output == 1){
            $deffuzifikasi = ["Aman",$output];
        } else if ($output == 2){
            $deffuzifikasi = ["Waspada",$output];
        } else if ($output == 3){
            $deffuzifikasi = ["Bahaya",$output];
        }
        return $deffuzifikasi;
    }
}
