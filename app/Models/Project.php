<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProjectDeliverable;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'service_id',
        'manager_id',
        'name',
        'description',
        'budget',
        'starts_at',
        'ends_at',
        'progress',
        'status',
        'priorite',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'starts_at' => 'date',
        'ends_at' => 'date',
        'progress' => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function equipe()
    {
        return $this->belongsToMany(Employee::class, 'employee_project')
                    ->withPivot('role_dans_projet')
                    ->withTimestamps();
    }

    public function deliverables()
    {
        return $this->hasMany(ProjectDeliverable::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}