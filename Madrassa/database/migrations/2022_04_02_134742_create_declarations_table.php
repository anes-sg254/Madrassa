<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declarations', function (Blueprint $table) {
            $table->id('id_declaration');
            //$table->foreignId('id')->constraint('users');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titre',255);
            $table->text('description');
            $table->text('lieu');
            $table->string('state',255)->default('created');
            $table->string('service',255)->nullable();
            $table->unsignedBigInteger('idCategorie')->nullable();
            $table->foreign('idCategorie')->references('idCategorie')->on('categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('declarations');
    }


}
