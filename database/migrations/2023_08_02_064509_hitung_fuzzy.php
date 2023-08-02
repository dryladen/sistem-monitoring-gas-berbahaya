<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_hitung_fuzzy', function (Blueprint $table) {
            $table->id();
            $table->float('gas_amonia')->nullable();
            $table->float('gas_metana')->nullable();
            $table->float('komposisi_aman')->nullable();
            $table->float('komposisi_waspada')->nullable();
            $table->float('komposisi_bahaya')->nullable();
            $table->float('nilai_a1')->nullable();
            $table->float('nilai_a2')->nullable();
            $table->float('output_deff')->nullable();
            $table->float('kondisi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_hitung_fuzzy');
    }
};
