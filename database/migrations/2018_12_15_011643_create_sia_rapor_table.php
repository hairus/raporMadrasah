<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiaRaporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siaRapor', function (Blueprint $table) {
            $table->id();
            $table->integer('nis');
            $table->integer('sakit');
            $table->integer('ijin');
            $table->integer('alpha');
            $table->integer('kelas_id');
            $table->integer('smt_id');
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
        Schema::dropIfExists('siaRapor');
    }
}
