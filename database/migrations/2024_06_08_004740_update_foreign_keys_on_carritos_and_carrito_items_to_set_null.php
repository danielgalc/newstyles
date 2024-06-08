<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar tabla 'carritos'
        Schema::table('carritos', function (Blueprint $table) {
            // Eliminar clave foránea existente
            $table->dropForeign(['user_id']);
            
            // Cambiar la columna para permitir valores nulos
            $table->foreignId('user_id')->nullable()->change();

            // Volver a crear la clave foránea con onDelete('set null')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Modificar tabla 'carrito_items'
        Schema::table('carrito_items', function (Blueprint $table) {
            // Eliminar claves foráneas existentes
            $table->dropForeign(['carrito_id']);
            $table->dropForeign(['producto_id']);
            
            // Cambiar las columnas para permitir valores nulos
            $table->foreignId('carrito_id')->nullable()->change();
            $table->foreignId('producto_id')->nullable()->change();

            // Volver a crear las claves foráneas con onDelete('set null')
            $table->foreign('carrito_id')->references('id')->on('carritos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios en la tabla 'carritos'
        Schema::table('carritos', function (Blueprint $table) {
            // Eliminar clave foránea con onDelete('set null')
            $table->dropForeign(['user_id']);

            // Volver a cambiar la columna para no permitir valores nulos
            $table->foreignId('user_id')->nullable(false)->change();

            // Volver a crear la clave foránea original
            $table->foreign('user_id')->references('id')->on('users')->unique();
        });

        // Revertir cambios en la tabla 'carrito_items'
        Schema::table('carrito_items', function (Blueprint $table) {
            // Eliminar claves foráneas con onDelete('set null')
            $table->dropForeign(['carrito_id']);
            $table->dropForeign(['producto_id']);

            // Volver a cambiar las columnas para no permitir valores nulos
            $table->foreignId('carrito_id')->nullable(false)->change();
            $table->foreignId('producto_id')->nullable(false)->change();

            // Volver a crear las claves foráneas originales
            $table->foreign('carrito_id')->references('id')->on('carritos');
            $table->foreign('producto_id')->references('id')->on('productos');
        });
    }
};
