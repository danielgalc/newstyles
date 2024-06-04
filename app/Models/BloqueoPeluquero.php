<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloqueoPeluquero extends Model
{
    use HasFactory;

    protected $table = 'bloqueos_peluqueros';

    protected $fillable = ['peluquero_id', 'fecha', 'horas'];

    protected $casts = [
        'horas' => 'array',
    ];

    public function peluquero()
    {
        return $this->belongsTo(User::class, 'peluquero_id');
    }
}