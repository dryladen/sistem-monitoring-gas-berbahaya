<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AturanFuzzy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rangeVariabel = [
            ['variabel1' => "Rendah", 'variabel2' => "Rendah", "konklusi" => "Aman"],
            ['variabel1' => "Rendah", 'variabel2' => "Normal", "konklusi" => "Aman"],
            ['variabel1' => "Rendah", 'variabel2' => "Tinggi", "konklusi" => "Waspada"],
            ['variabel1' => "Normal", 'variabel2' => "Rendah", "konklusi" => "Aman"],
            ['variabel1' => "Normal", 'variabel2' => "Normal", "konklusi" => "Waspada"],
            ['variabel1' => "Normal", 'variabel2' => "Tinggi", "konklusi" => "Waspada"],
            ['variabel1' => "Tinggi", 'variabel2' => "Rendah", "konklusi" => "Bahaya"],
            ['variabel1' => "Tinggi", 'variabel2' => "Normal", "konklusi" => "Bahaya"],
            ['variabel1' => "Tinggi", 'variabel2' => "Tinggi", "konklusi" => "Bahaya"],
        ];
        DB::table('tbl_aturan_fuzzy')->insert($rangeVariabel);
    }
}
