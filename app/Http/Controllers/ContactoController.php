<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ContactoController extends Controller
{
    public function sendMail(Request $request)
    {
        // Definir reglas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ];

        // Definir mensajes de error personalizados
        $messages = [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no puede exceder los 255 caracteres.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El campo correo electrónico debe ser una dirección de correo válida.',
            'email.max' => 'El campo correo electrónico no puede exceder los 255 caracteres.',
            'subject.required' => 'El campo asunto es obligatorio.',
            'subject.string' => 'El campo asunto debe ser una cadena de texto.',
            'subject.max' => 'El campo asunto no puede exceder los 255 caracteres.',
            'message.required' => 'El campo mensaje es obligatorio.',
            'message.string' => 'El campo mensaje debe ser una cadena de texto.',
        ];

        // Validar la solicitud
        $request->validate($rules, $messages);

        try {
            $data = [
                'name' => (string) $request->input('name'),
                'email' => (string) $request->input('email'),
                'subject' => (string) $request->input('subject'),
                'content' => (string) $request->input('message'),
            ];

            Mail::send('emails.contacto', $data, function ($message) use ($data) {
                $message->to('info@newstyles.com', 'NewStyles')
                        ->subject($data['subject'])
                        ->from($data['email'], $data['name']);
            });

            return redirect()->back()->with('success', '¡Correo enviado con éxito!');
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error enviando el correo');
        }
    }
}
