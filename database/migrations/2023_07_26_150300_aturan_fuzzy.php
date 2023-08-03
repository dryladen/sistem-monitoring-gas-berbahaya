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
        Schema::create('tbl_aturan_fuzzy', function (Blueprint $table) {
            $table->id();
            $table->string('variabel1')->nullable();
            $table->string('variabel2')->nullable();
            $table->string('konklusi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_aturan_fuzzy');
    }
};
