<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'name', 'tagline', 'address', 'phone', 'email',
        'rccm', 'ifu', 'logo'
        , 'primary_color', 'secondary_color', 'text_color'
    ];
}
