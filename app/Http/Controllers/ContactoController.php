<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactoController extends Controller
{
    public function sendMail(Request $request)
    {
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

            return response()->json(['message' => 'Email sent successfully'], 200);
        } catch (\Exception $e) {
            Log::error('Error sending email: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send email', 'error' => $e->getMessage()], 500);
        }
    }
}
