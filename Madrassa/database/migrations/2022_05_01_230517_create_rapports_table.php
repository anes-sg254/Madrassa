<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRapportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapports', function (Blueprint $table) {
            $table->id('id_rapport');
            $table->unsignedBigInteger('id_declaration');
            $table->foreign('id_declaration')->references('id_declaration')->on('declarations')->onDelete('cascade')->onUpdate('cascade');
            $table->string('file');
            $table->string('state')->default('no_valide');
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
        Schema::dropIfExists('rapports');
    }
}
