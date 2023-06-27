<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambarKamar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambar_kamar', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kamar_id')->unsigned();
            $table->text('gambar');
            $table->timestamps();
            $table->foreign('kamar_id')->references('id')->on('kamar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gambar_kamar');
    }
}
