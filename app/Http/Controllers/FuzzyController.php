<?php

namespace App\Http\Controllers;

use App\Models\AturanFuzzy;
use App\Models\DataFuzzy;
use App\Models\DataGas;
use App\Models\RangeFuzzy;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FuzzyController extends Controller
{
    public function index()
    {
        $data = array(
            "title" => "Himpunan Fuzzy",
            "data_fuzzy" => RangeFuzzy::join("tbl_variabel_fuzzy", "tbl_variabel_fuzzy.id", "=", "tbl_range_fuzzy.id")->select("tbl_range_fuzzy.*", "tbl_variabel_fuzzy.variabel")->get(),
            "aturan_fuzzy" => AturanFuzzy::all(),
            'user' => Auth::user()->name,
            "amonia" => $this->getData()['amonia'],
            "metana" => $this->getData()['amonia'],
            "fuzzy_mamdani" => $this->fuzzyMamdani($this->getData()['amonia'], $this->getData()['amonia'])
        );
        return view('fuzzy', $data);
    }
    private function getData()
    {
        $response = Http::withHeaders([
            'X-M2M-Origin' => "d62b58a24f685c68:e294312a591f2234",
        ])->get('https://platform.antares.id:8443/~/antares-cse/antares-id/KandangAyam_Bantuas/Data1/la');
        $dataJson = json_decode($response, true);
        return json_decode($dataJson['m2m:cin']['con'], true);
    }

    public function hitungUlangKondisi()
    {
        $dataGas = DataFuzzy::all();
        foreach ($dataGas as $data) {
            $nilai_kondisi = $this->fuzzyMamdani($data->gas_amonia, $data->gas_metana);
            DataFuzzy::where('id', $data->id)->where('id',$data->id)->update([
                'komposisi_aman' => $nilai_kondisi['komposisi_aturan'][0],
                'komposisi_waspada' => $nilai_kondisi['komposisi_aturan'][1],
                'komposisi_bahaya' => $nilai_kondisi['komposisi_aturan'][2],
                'nilai_a1' => $nilai_kondisi['nilai_keanggotaan']['a1'],
                'nilai_a2' => $nilai_kondisi['nilai_keanggotaan']['a2'],
                'output_deff' => $nilai_kondisi['output'][1],
                'kondisi' => $nilai_kondisi['output'][0]
            ]);
        }
        return redirect('/riwayat_monitoring');
    }
    public function dataGas()
    {
        // Mengambil 10 data terakhir
        $dataGas = DataFuzzy::latest()->take(10)->get()->sortBy('id');
        $dataGas_last = DataFuzzy::latest()->first();
        $dates = $dataGas->pluck('created_at');
        $labels = [];
        // Konversi waktu dalam bentuk (Jam:Menit)
        foreach ($dates as $date) {
            $carbonDate = Carbon::parse($date);
            $formattedDate = $carbonDate->format('H:i');
            $labels[] = $formattedDate;
        }
        $amonia = $dataGas->pluck('gas_amonia');
        $metana = $dataGas->pluck('gas_metana');
        $nilai_last_amonia = $dataGas_last->gas_amonia;
        $nilai_last_metana = $dataGas_last->gas_metana;
        $nilai_kondisi = $this->fuzzyMamdani($nilai_last_amonia, $nilai_last_metana);

        return response()->json(compact('labels', 'amonia', 'metana', 'nilai_last_amonia', 'nilai_last_metana', 'nilai_kondisi'));
    }

    //  ! Kodingan perhitungan fuzzy

    // ! Fuzifikasi
    // ? Fungsi keanggotaan segitiga
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

    // ? Fungsi keanggotaan linear naik
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

    // ? Fungsi keanggotaan linear turun
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
    // ? Fungsi keanggotaan linear turun
    private function fTrapesium($x, $a, $b, $c, $d)
    {
        if ($x >= $b && $x <= $c) {
            return 1;
        } elseif ($x < $a && $x > $d) {
            return 0;
        } elseif ($x >= $a && $x <= $b) {
            return ($x-$a)/($b-$a);
        } elseif ($x >= $c && $x <= $d) {
            return ($d-$x)/($d-$c);
        } else {
            return 0;
        }
    }

    // ! Fungsi Fuzzifikasi
    private function fuzzifikasi($data_amonia, $data_metana)
    {
        $variabel_fuzzy = RangeFuzzy::all();
        // ? Menghitung derajat keanggotaan
        $derajat_keanggotaan = array(
            "Amonia" => array(
                "Normal" => $this->fLinearTurun(
                    $data_amonia, $variabel_fuzzy[0]["a"], $variabel_fuzzy[0]["b"]),
                "Sedang" => $this->fTrapesium(
                    $data_amonia, $variabel_fuzzy[1]["a"], $variabel_fuzzy[1]["b"], $variabel_fuzzy[1]["c"], $variabel_fuzzy[1]["d"]),
                "Tinggi" => $this->fLinearNaik(
                    $data_amonia, $variabel_fuzzy[2]["a"], $variabel_fuzzy[2]["b"]),
            ),
            "Metana" => array(
                "Rendah" => $this->fLinearTurun(
                    $data_metana, $variabel_fuzzy[3]["a"], $variabel_fuzzy[3]["b"]),
                "Normal" => $this->fSegitiga(
                    $data_metana, $variabel_fuzzy[4]["a"], $variabel_fuzzy[4]["b"], $variabel_fuzzy[4]["c"]),
                "Tinggi" => $this->fLinearNaik(
                    $data_metana, $variabel_fuzzy[5]["a"], $variabel_fuzzy[5]["b"]),
            )
        );
        return $derajat_keanggotaan;
    }

    // ! Fungsi Implikasi
    private function fungsiImplikasi($derajat_keanggotaan) {
        $aturanFuzzy = DB::table("tbl_aturan_fuzzy")->get();
        $alpa_predikat = array();
        foreach ($aturanFuzzy as $item) {
            // Menentukan Alpa Predikat menggunakan metode Min berdasarkan aturan fuzzy
            array_push(
                $alpa_predikat,
                min($derajat_keanggotaan["Amonia"][$item->variabel1], $derajat_keanggotaan["Metana"][$item->variabel2])
            );
        }
        return $alpa_predikat;
    }

    // ! Fungsi Komposisi Aturan 
    private function komposisiAturan($alpa_predikat) {
        $komposisi_aturan = array();
        array_push($komposisi_aturan, max($alpa_predikat[0], $alpa_predikat[1], $alpa_predikat[3]));
        array_push($komposisi_aturan, max($alpa_predikat[2], $alpa_predikat[4], $alpa_predikat[6]));
        array_push($komposisi_aturan, max($alpa_predikat[5], $alpa_predikat[7], $alpa_predikat[8]));

        // Menentukan komposisi aturan dengan menggunakan metode Max
        if ($komposisi_aturan[0] > $komposisi_aturan[1] && $komposisi_aturan[0] > $komposisi_aturan[2]) {
            array_push($komposisi_aturan, "Aman");
        } else if ($komposisi_aturan[1] > $komposisi_aturan[0] && $komposisi_aturan[1] > $komposisi_aturan[2]) {
            array_push($komposisi_aturan, "Waspada");
        } else if ($komposisi_aturan[2] > $komposisi_aturan[0] && $komposisi_aturan[2] > $komposisi_aturan[1]) {
            array_push($komposisi_aturan, "Bahaya");
        } else {
            array_push($komposisi_aturan, "Aman");
        }
        return $komposisi_aturan;
    }

    // ! Mencari a1 dan a2 untuk deffuzifikasi
    private function nilaiKeanggotaan($komposisi_aturan)
    {
        $variabel_fuzzy = DB::table('tbl_range_fuzzy')->get();
        $a1 = 0;
        $a2 = 0;
        if ($komposisi_aturan[3] == "Aman") {
            $a1 = $variabel_fuzzy[6]->a  + ($komposisi_aturan[0] * ($variabel_fuzzy[6]->b - $variabel_fuzzy[6]->a));
            $a2 = $variabel_fuzzy[6]->c  - ($komposisi_aturan[0] * ($variabel_fuzzy[6]->c - $variabel_fuzzy[6]->b));
        } else if ($komposisi_aturan[3] == "Waspada") {
            $a1 = $variabel_fuzzy[7]->a  + ($komposisi_aturan[1] * ($variabel_fuzzy[7]->b - $variabel_fuzzy[7]->a));
            $a2 = $variabel_fuzzy[7]->c  - ($komposisi_aturan[1] * ($variabel_fuzzy[7]->c - $variabel_fuzzy[7]->b));
        } else if ($komposisi_aturan[3] == "Bahaya") {
            $a1 = $variabel_fuzzy[8]->a  + ($komposisi_aturan[1] * ($variabel_fuzzy[8]->b - $variabel_fuzzy[8]->a));
            $a2 = $variabel_fuzzy[8]->c  - ($komposisi_aturan[1] * ($variabel_fuzzy[8]->c - $variabel_fuzzy[8]->b));
        };
        $nilai_keanggotaan = ["a1" => $a1, "a2" => $a2];
        return $nilai_keanggotaan;
    }

    // ! Fungsi Deffuzifikasi
    private function deffuzifikasi($nilai_keanggotaan)
    {
        $a1 = $nilai_keanggotaan["a1"];
        $a2 = $nilai_keanggotaan["a2"];
        // Menggunakan rumus MoM (Mean Of Maximum)
        $output = ((($a1 - $a2 + 1) * ($a1 + $a2)) / 2) / ($a1 - $a2 + 1);
        if ($output == 1) {
            $deffuzifikasi = ["Aman", $output];
        } else if ($output == 2) {
            $deffuzifikasi = ["Waspada", $output];
        } else if ($output == 3) {
            $deffuzifikasi = ["Bahaya", $output];
        }
        return $deffuzifikasi;
    }

    private function fuzzyMamdani($data_amonia, $data_metana)
    {
        // Fuzzifikasi
        $derajat_keanggotaan = $this->fuzzifikasi($data_amonia, $data_metana);
        // Fungsi Implikasi
        $alpa_predikat = $this->fungsiImplikasi($derajat_keanggotaan);
        // Komposisi Aturan
        $komposisi_aturan = $this->komposisiAturan($alpa_predikat);
        // mencari a1 dan a2
        $nilai_keanggotaan = $this->nilaiKeanggotaan($komposisi_aturan);
        // Deffuzifikasi
        $deffuzifikasi = $this->deffuzifikasi($nilai_keanggotaan);

        $FuzzyMamdani = array(
            'data_amonia' => $data_amonia,
            'data_metana' => $data_metana,
            'derajat_keanggotaan' => $derajat_keanggotaan,
            'alpa_predikat' => $alpa_predikat,
            'komposisi_aturan' => $komposisi_aturan,
            'nilai_keanggotaan' => $nilai_keanggotaan,
            'output' => $deffuzifikasi
        );
        return $FuzzyMamdani;
    }
}
