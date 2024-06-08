<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysOnPedidosToSetNull extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modificar tabla 'pedidos'
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar clave foránea existente
            $table->dropForeign(['user_id']);
            
            // Cambiar la columna para permitir valores nulos
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Volver a crear la clave foránea con onDelete('set null')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // Modificar tabla 'pedido_producto'
        Schema::table('pedido_producto', function (Blueprint $table) {
            // Eliminar claves foráneas existentes
            $table->dropForeign(['pedido_id']);
            $table->dropForeign(['producto_id']);
            
            // Cambiar las columnas para permitir valores nulos
            $table->unsignedBigInteger('pedido_id')->nullable()->change();
            $table->unsignedBigInteger('producto_id')->nullable()->change();

            // Volver a crear las claves foráneas con onDelete('set null')
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios en la tabla 'pedidos'
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar clave foránea con onDelete('set null')
            $table->dropForeign(['user_id']);

            // Volver a cambiar la columna para no permitir valores nulos
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Volver a crear la clave foránea original
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Revertir cambios en la tabla 'pedido_producto'
        Schema::table('pedido_producto', function (Blueprint $table) {
            // Eliminar claves foráneas con onDelete('set null')
            $table->dropForeign(['pedido_id']);
            $table->dropForeign(['producto_id']);

            // Volver a cambiar las columnas para no permitir valores nulos
            $table->unsignedBigInteger('pedido_id')->nullable(false)->change();
            $table->unsignedBigInteger('producto_id')->nullable(false)->change();

            // Volver a crear las claves foráneas originales
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
};
