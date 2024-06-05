<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'productos',
        'precio_total',
        'user_id',
        'dni',
        'telefono',
        'direccion',
    ];

    protected $casts = [
        'productos' => 'array', // Para que Laravel convierta el JSON a un array automáticamente
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed(); // Para mantener la relación con usuarios eliminados
    }

    public function productos(): BelongsToMany
    {
        return $this->belongsToMany(Producto::class)->withPivot('cantidad');
    }
}
