<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignKeysOnPedidosAndPedidoProducto extends Migration
{
    public function up()
    {
        // Modificar tabla 'pedidos'
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar clave foránea existente
            $table->dropForeign(['user_id']);
            // Volver a crear la clave foránea con onDelete('restrict')
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });

        // Modificar tabla 'pedido_producto'
        Schema::table('pedido_producto', function (Blueprint $table) {
            // Eliminar claves foráneas existentes
            $table->dropForeign(['pedido_id']);
            $table->dropForeign(['producto_id']);
            // Volver a crear las claves foráneas con onDelete('restrict')
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('restrict');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('restrict');
        });
    }

    public function down()
    {
        // Revertir cambios en la tabla 'pedidos'
        Schema::table('pedidos', function (Blueprint $table) {
            // Eliminar clave foránea con onDelete('restrict')
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Revertir cambios en la tabla 'pedido_producto'
        Schema::table('pedido_producto', function (Blueprint $table) {
            // Eliminar claves foráneas con onDelete('restrict')
            $table->dropForeign(['pedido_id']);
            $table->dropForeign(['producto_id']);
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }
}
