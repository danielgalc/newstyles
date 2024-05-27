<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    protected $fillable = ['servicio', 'fecha'];
    // Indica que los campos 'fecha' y 'hora' deben ser tratados como fechas
    protected $dates = ['fecha', 'hora'];

    /**
     * Get the user that owns the cita.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peluquero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peluquero_id');
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class, 'servicio');
    }
    
}
