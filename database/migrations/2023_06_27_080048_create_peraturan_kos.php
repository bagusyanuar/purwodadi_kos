<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeraturanKos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peraturan_kos', function (Blueprint $table) {
            $table->primary(['kos_id', 'peraturan_id']);
            $table->bigInteger('kos_id')->unsigned();
            $table->bigInteger('peraturan_id')->unsigned();
            $table->foreign('kos_id')->references('id')->on('kos');
            $table->foreign('peraturan_id')->references('id')->on('peraturan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peraturan_kos');
    }
}
