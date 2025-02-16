<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNilaiAkhirsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nilai_akhirs', function (Blueprint $table) {
            $table->id();
            $table->integer('nis');
            $table->integer('kelas_id');
            $table->string('smt');
            $table->integer('tas_id');
            $table->integer('ranking');
            $table->integer('total_nilai')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nilai_akhirs');
    }
}
