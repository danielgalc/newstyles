<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    public function carritos(): HasMany
    {
        return $this->hasMany(Carrito::class);
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_producto', 'producto_id', 'pedido_id')->withPivot('cantidad');
    }

}
