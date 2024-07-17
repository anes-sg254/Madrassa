<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePictureDecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_decs', function (Blueprint $table) {
            //$table->foreignId('id_declaration')->constraint('declarations');
            $table->unsignedBigInteger('id_dec');
            $table->foreign('id_dec')->references('id_declaration')->on('declarations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('picture');
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
        Schema::dropIfExists('picture_decs');
    }
}
