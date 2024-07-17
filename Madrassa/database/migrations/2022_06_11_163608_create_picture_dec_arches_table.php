<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePictureDecArchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_dec_arches', function (Blueprint $table) {
            $table->unsignedBigInteger('id_dec');
            $table->foreign('id_dec')->references('id_declaration')->on('declaration_arches')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('picture_dec_arches');
    }
}
