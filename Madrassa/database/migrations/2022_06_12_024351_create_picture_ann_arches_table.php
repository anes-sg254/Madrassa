<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePictureAnnArchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('picture_ann_arches', function (Blueprint $table) {
            $table->unsignedBigInteger('id_annonce');
            $table->foreign('id_annonce')->references('id_annonce')->on('annonce_arches')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('picture_ann_arches');
    }
}
