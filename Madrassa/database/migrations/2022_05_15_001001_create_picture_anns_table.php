<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePictureAnnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_anns', function (Blueprint $table) {
            $table->unsignedBigInteger('id_annonce');
            $table->foreign('id_annonce')->references('id_annonce')->on('annonces')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('picture_anns');
    }
}
