<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pedido_producto', function (Blueprint $table) {
            $table->string('nombre_producto')->nullable()->after('producto_id');
        });
    }

    public function down()
    {
        Schema::table('pedido_producto', function (Blueprint $table) {
            $table->dropColumn('nombre_producto');
        });
    }
};
