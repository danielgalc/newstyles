<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HoraValida implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Permitir formato "H:i" o "H:i:s"
        if (!preg_match('/^\d{2}:\d{2}$/', $value) && !preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
            $fail('El campo :attribute debe ser una hora válida en el formato HH:MM o HH:MM:SS.');
        }
    }
}
