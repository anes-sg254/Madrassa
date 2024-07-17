<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attaches', function (Blueprint $table) {
            $table->integer('idDeclaration1');
            $table->unsignedBigInteger('idDeclaration2')->nullable();
            $table->foreign('idDeclaration2')->references('id_declaration')->on('declarations')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attaches');
    }
}
