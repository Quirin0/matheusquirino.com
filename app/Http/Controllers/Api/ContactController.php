<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:2000',
        ]);

        $toEmail  = Setting::get('contact.email', config('mail.from.address'));
        $fromName = Setting::get('smtp.from_name', 'Portfólio');

        // Configurar SMTP dinamicamente a partir das settings
        config([
            'mail.mailers.smtp.host'       => Setting::get('smtp.host', config('mail.mailers.smtp.host')),
            'mail.mailers.smtp.port'       => Setting::get('smtp.port', config('mail.mailers.smtp.port')),
            'mail.mailers.smtp.username'   => Setting::get('smtp.username'),
            'mail.mailers.smtp.password'   => Setting::get('smtp.password'),
            'mail.mailers.smtp.encryption' => Setting::get('smtp.encryption', 'tls'),
            'mail.from.address'            => Setting::get('contact.email', 'contato@site.com'),
            'mail.from.name'               => $fromName,
        ]);

        try {
            Mail::raw(
                "Nome: {$validated['name']}\nEmail: {$validated['email']}\n\nMensagem:\n{$validated['message']}",
                function ($mail) use ($validated, $toEmail, $fromName) {
                    $mail->to($toEmail)
                         ->replyTo($validated['email'], $validated['name'])
                         ->subject("Contato via portfólio: {$validated['name']}");
                }
            );

            return response()->json(['message' => 'Mensagem enviada com sucesso!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao enviar mensagem.'], 500);
        }
    }
}
