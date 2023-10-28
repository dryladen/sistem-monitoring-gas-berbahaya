<?php

namespace App\Console\Commands;

use App\Models\DataFuzzy;
use App\Models\OutputFuzzy;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RealTimeMonitoring extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'RealTimeMonitoring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

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

    // ! Fungsi Implikasi
    private function fuzzifikasi($data_amonia, $data_metana)
    {
        $variabel_fuzzy = DataFuzzy::all();
        // ? Menghitung derajat keanggotaan
        $derajat_keanggotaan = array(
            "Amonia" => array(
                "Rendah" => $this->fSegitiga($data_amonia, $variabel_fuzzy[0]["a"], $variabel_fuzzy[0]["b"], $variabel_fuzzy[0]["c"]),
                "Normal" => $this->fSegitiga($data_amonia, $variabel_fuzzy[1]["a"], $variabel_fuzzy[1]["b"], $variabel_fuzzy[1]["c"]),
                "Tinggi" => $this->fSegitiga($data_amonia, $variabel_fuzzy[2]["a"], $variabel_fuzzy[2]["b"], $variabel_fuzzy[2]["c"]),
            ),
            "Metana" => array(
                "Rendah" => $this->fLinearTurun($data_metana, $variabel_fuzzy[3]["a"], $variabel_fuzzy[3]["b"]),
                "Normal" => $this->fSegitiga($data_metana, $variabel_fuzzy[4]["a"], $variabel_fuzzy[4]["b"], $variabel_fuzzy[4]["c"]),
                "Tinggi" => $this->fLinearNaik($data_metana, $variabel_fuzzy[5]["a"], $variabel_fuzzy[5]["b"]),
            )
        );
        return $derajat_keanggotaan;
    }

    private function fungsiImplikasi($derajat_keanggotaan)
    {
        $aturanFuzzy = DB::table("tbl_aturan_fuzzy")->get();
        $alpa_predikat = array();
        foreach ($aturanFuzzy as $item) {
            array_push($alpa_predikat, min($derajat_keanggotaan["Amonia"][$item->variabel1], $derajat_keanggotaan["Metana"][$item->variabel2]));
        }
        return $alpa_predikat;
    }
    // Mencari nilai maksimum 
    private function komposisiAturan($alpa_predikat)
    {
        $komposisi_aturan = array();
        array_push($komposisi_aturan, max($alpa_predikat[0], $alpa_predikat[1], $alpa_predikat[3]));
        array_push($komposisi_aturan, max($alpa_predikat[2], $alpa_predikat[4], $alpa_predikat[5]));
        array_push($komposisi_aturan, max($alpa_predikat[6], $alpa_predikat[7], $alpa_predikat[8]));

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
    // Mencari a1 dan a2 untuk deffuzifikasi
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

    private function deffuzifikasi($nilai_keanggotaan)
    {
        $a1 = $nilai_keanggotaan["a1"];
        $a2 = $nilai_keanggotaan["a2"];
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
    private function getData()
    {
        $response = Http::withHeaders([
            'X-M2M-Origin' => "d62b58a24f685c68:e294312a591f2234",
        ])->get('https://platform.antares.id:8443/~/antares-cse/antares-id/KandangAyam_Bantuas/Data1/la');
        $dataJson = json_decode($response, true);
        return json_decode($dataJson['m2m:cin']['con'], true);
    }
    public function handle()
    {
        //Mengambil data dari API
        $amonia = $this->getData()['amonia'];
        $metana = $this->getData()['metana'];
        DB::table('tbl_data_gas')->insert([
            'gas_amonia' => $amonia,
            'gas_metana' => $metana,
        ]);
        // Cmd run schedul : php artisan schedule:work
        // Ini masih bermasalah menyimpan data ke database
        // ! Perhitungan Fuzzy
        $dataFuzzy = $this->fuzzyMamdani($amonia, $metana);
        //  ! Menyimpan Perhitungan ke Database
        OutputFuzzy::create([
            'gas_amonia' => $amonia,
            'gas_metana' => $metana,
            'komposisi_aman' => $dataFuzzy['komposisi_aturan'][0],
            'komposisi_waspada' => $dataFuzzy['komposisi_aturan'][1],
            'komposisi_bahaya' => $dataFuzzy['komposisi_aturan'][2],
            'nilai_a1' => $dataFuzzy['nilai_keanggotaan']['a1'],
            'nilai_a2' => $dataFuzzy['nilai_keanggotaan']['a2'],
            'output_deff' => $dataFuzzy['output'][1],
            'kondisi' => $dataFuzzy['output'][0]
        ]);
    }
}
