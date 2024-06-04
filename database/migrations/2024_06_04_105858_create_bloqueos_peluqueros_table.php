<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueosPeluquerosTable extends Migration
{
    public function up()
    {
        Schema::create('bloqueos_peluqueros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peluquero_id');
            $table->date('fecha');
            $table->json('horas')->nullable();
            $table->timestamps();

            $table->foreign('peluquero_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bloqueos_peluqueros');
    }
}

