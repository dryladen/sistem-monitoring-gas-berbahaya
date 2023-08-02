<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariabelFuzzy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataVariabel = [
            ['tipe' => 'input', 'variabel' => "amonia_rendah"],
            ['tipe' => 'input', 'variabel' => "amonia_normal"],
            ['tipe' => 'input', 'variabel' => "amonia_tinggi"],
            ['tipe' => 'input', 'variabel' => "metana_rendah"],
            ['tipe' => 'input', 'variabel' => "metana_normal"],
            ['tipe' => 'input', 'variabel' => "metana_tinggi"],
            ['tipe' => 'input', 'variabel' => "kondisi_aman"],
            ['tipe' => 'input', 'variabel' => "kondisi_waspada"],
            ['tipe' => 'input', 'variabel' => "kondisi_bahaya"],
        ];
        DB::table('tbl_variabel_fuzzy')->insert($dataVariabel);
    }
}
