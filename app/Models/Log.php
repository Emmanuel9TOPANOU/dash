<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_id',
        'actor_type',
        'action',
        'type',
        'ip',
    ];

    /**
     * Relation polymorphique : un log peut appartenir à un admin (User)
     * ou à un employé (Employee)
     */
    public function actor()
    {
        return $this->morphTo();
    }
}
