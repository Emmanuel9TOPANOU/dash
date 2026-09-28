<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmployeSupportController extends Controller
{
    /**
     * Gère l’envoi du message de support depuis l’espace employé
     */
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // 📩 Envoi d’un mail au support (tu peux changer l’adresse)
        Mail::raw(
            "Message de support :\n\n" . $request->message,
            function ($mail) use ($request) {
                $mail->to('stagestindevelvirex@gmail.com')
                    ->subject('🧾 Support employé : ' . $request->subject);
            }
        );

        return back()->with('success', '✅ Votre message a été envoyé avec succès. Nous vous répondrons bientôt.');
    }
}
