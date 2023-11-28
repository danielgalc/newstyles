<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cita extends Model
{
    protected $fillable = ['servicio', 'fecha'];

    /**
     * Get the user that owns the cita.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function peluquero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peluquero_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
    
}
