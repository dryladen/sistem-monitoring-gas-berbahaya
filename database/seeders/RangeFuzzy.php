<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RangeFuzzy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rangeVariabel = [
            ['id_variabel' => 1, 'a' => 0, "b" => 5, "c" => 10],
            ['id_variabel' => 2, 'a' => 5, "b" => 15, "c" => 25],
            ['id_variabel' => 3, 'a' => 20, "b" => 35, "c" => 50],
            ['id_variabel' => 4, 'a' => 30, "b" => 70, "c" => 0],
            ['id_variabel' => 5, 'a' => 40, "b" => 70, "c" => 100],
            ['id_variabel' => 6, 'a' => 70, "b" => 110, "c" => 0],
            ['id_variabel' => 7, 'a' => 0, "b" => 1, "c" => 2],
            ['id_variabel' => 8, 'a' => 1, "b" => 2, "c" => 3],
            ['id_variabel' => 9, 'a' => 2, "b" => 3, "c" => 4],
        ];
        DB::table('tbl_range_fuzzy')->insert($rangeVariabel);
    }
}
