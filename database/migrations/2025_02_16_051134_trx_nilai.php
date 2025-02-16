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
        Schema::create('trx_nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nis');
            $table->string('nilai');
            $table->string('kelas_id');
            $table->string('mapel_id');
            $table->string('smt');
            $table->string('tas_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trx_nilai');
    }
};
