<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'sender_role',
        'message',
        'file'
    ];

    public function sender()
    {
        return $this->belongsTo(Employee::class, 'sender_id');
    }

    public function senderModel()
    {
        if ($this->sender_role === 'user') {
            return \App\Models\User::find($this->sender_id);
        }

        return \App\Models\Employee::find($this->sender_id);
    }

    public function getSenderNameAttribute()
    {
        // Si l'expéditeur est un administrateur (sender_role = 'admin')
        if ($this->sender_role === 'admin') {
            return \App\Models\User::find($this->sender_id)?->name ?? 'Administrateur';
        }

        // Sinon c'est un employé
        return $this->sender?->prenom . ' ' . $this->sender?->nom;
    }

}
