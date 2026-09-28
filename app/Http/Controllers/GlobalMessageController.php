<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class GlobalMessageController extends Controller
{
    /**
     * 📌 Affichage global des messages
     */
    public function index()
    {
        $messages = Message::with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('messagerie.index', compact('messages'));
    }

    /**
     * 📌 Envoi d’un message (Admin + Employé)
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'file' => 'nullable|file|max:2048'
        ]);

        // ADMIN connecté ?
        if (auth()->check()) {
            $senderId = auth()->id();
            $senderRole = 'admin';
        }
        // EMPLOYÉ connecté ?
        elseif (session('employee_id')) {
            $employee = Employee::find(session('employee_id'));
            $senderId = $employee->id;
            $senderRole = $employee->role;
        } else {
            return back()->with('error', 'Impossible d’identifier l’expéditeur.');
        }

        // Upload fichier
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('messages', 'public');
        }

        $message = Message::create([
            'sender_id' => $senderId,
            'sender_role' => $senderRole,
            'message' => $request->message,
            'file' => $filePath
        ]);

        if ($senderRole !== 'admin') {
            Notification::notifyAdmins(
                'message',
                'Nouveau message',
                $employee->prenom . ' ' . $employee->nom . ' a envoyé un message dans la messagerie.',
                route('messagerie.index')
            );
        }

        return back()->with('success', 'Message envoyé !');
    }
}
