<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('peluquero_id')->constrained('users');
            $table->string('servicio');
            $table->date('fecha'); // Cambiado a date para almacenar solo la fecha
            $table->time('hora'); // Agregado campo para almacenar la hora
            $table->enum('estado', ['pendiente', 'aceptada', 'cancelada', 'finalizada'])->default('pendiente');
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
}
