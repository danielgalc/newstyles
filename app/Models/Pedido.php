<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'productos',
        'precio_total',
        'fecha_compra',
        'dni',
        'telefono',
        'direccion',
        'estado',
        'transaccion',
    ];

    // Generar un valor de transacción único
    public static function generarTransaccion()
    {
        $ultimoPedido = self::orderBy('id', 'desc')->first();
        $ultimoId = $ultimoPedido ? $ultimoPedido->id : 0;
        $nuevoId = $ultimoId + 1;
        return 'NWS#' . str_pad($nuevoId, 6, '0', STR_PAD_LEFT);
    }

    protected $casts = [
        'productos' => 'array', // Para que Laravel convierta el JSON a un array automáticamente
    ];

    public function user()
    {
        return $this->belongsTo(User::class); // Para mantener la relación con usuarios eliminados
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'pedido_producto')
                    ->withPivot('cantidad'); // assuming 'cantidad' is a column in the pivot table
    }
}
