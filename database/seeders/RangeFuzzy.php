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
            ['id_variabel' => 1, 'a' => 20, "b" => 30, "c" => 0, "d" => 0],
            ['id_variabel' => 2, 'a' => 20, "b" => 30, "c" => 50, "d" => 60],
            ['id_variabel' => 3, 'a' => 50, "b" => 60, "c" => 0, "d" => 0],
            ['id_variabel' => 4, 'a' => 30, "b" => 70, "c" => 0, "d" => 0],
            ['id_variabel' => 5, 'a' => 40, "b" => 70, "c" => 100, "d" => 0],
            ['id_variabel' => 6, 'a' => 70, "b" => 110, "c" => 0, "d" => 0],
            ['id_variabel' => 7, 'a' => 0, "b" => 1, "c" => 2, "d" => 0],
            ['id_variabel' => 8, 'a' => 1, "b" => 2, "c" => 3, "d" => 0],
            ['id_variabel' => 9, 'a' => 2, "b" => 3, "c" => 4, "d" => 0],
        ];
        DB::table('tbl_range_fuzzy')->insert($rangeVariabel);
    }
}
