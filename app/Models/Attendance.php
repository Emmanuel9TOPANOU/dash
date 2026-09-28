<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    public const START_TIME = '08:00:00';
    public const MONDAY_TO_THURSDAY_END_TIME = '18:30:00';
    public const FRIDAY_END_TIME = '13:00:00';

    protected $fillable = [
        'employee_id',
        'date',
        'heure_arrivee',
        'heure_depart',
        'statut',
        'retard_minutes',
        'minutes_travaillees',
    ];

    protected static function booted()
    {
        static::saving(function ($attendance) {
            $heureStandard = Carbon::createFromTimeString(self::START_TIME);

            if ($attendance->heure_arrivee) {
                $arrivee = Carbon::parse($attendance->heure_arrivee);
                if ($arrivee->greaterThan($heureStandard)) {
                    $attendance->statut = 'en_retard';
                    $attendance->retard_minutes = $arrivee->diffInMinutes($heureStandard);
                } else {
                    $attendance->statut = 'a_lheure';
                    $attendance->retard_minutes = 0;
                }
            }

            if ($attendance->heure_arrivee && $attendance->heure_depart) {
                $arr = Carbon::parse($attendance->heure_arrivee);
                $dep = Carbon::parse($attendance->heure_depart);
                $attendance->minutes_travaillees = max(0, $dep->diffInMinutes($arr));
            }
        });
    }

    public function isPunctual(): bool
    {
        if (!$this->date || !$this->heure_arrivee) {
            return false;
        }

        $date = Carbon::parse($this->date);

        if (!$date->isWeekday() || Carbon::parse($this->heure_arrivee)->format('H:i:s') > self::START_TIME) {
            return false;
        }

        if (!$this->heure_depart) {
            return true;
        }

        $heureFinPrevue = $this->expected_departure_time;

        return $heureFinPrevue !== null
            && Carbon::parse($this->heure_depart)->format('H:i:s') >= $heureFinPrevue;
    }

    /** Heure de départ attendue selon le jour travaillé. */
    public function getExpectedDepartureTimeAttribute(): ?string
    {
        if (!$this->date) {
            return null;
        }

        $date = Carbon::parse($this->date);

        if ($date->isFriday()) {
            return self::FRIDAY_END_TIME;
        }

        return $date->isWeekday() ? self::MONDAY_TO_THURSDAY_END_TIME : null;
    }

    /** Nombre de minutes manquantes lorsque le départ est avant l'horaire prévu. */
    public function getEarlyDepartureMinutesAttribute(): int
    {
        if (!$this->date || !$this->heure_depart || !$this->expected_departure_time) {
            return 0;
        }

        $date = Carbon::parse($this->date)->toDateString();
        $departure = Carbon::parse("{$date} {$this->heure_depart}");
        $expectedDeparture = Carbon::parse("{$date} {$this->expected_departure_time}");

        return $departure->lessThan($expectedDeparture)
            ? $departure->diffInMinutes($expectedDeparture)
            : 0;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withDefault([
            'prenom' => 'Employé',
            'nom' => 'indisponible',
        ]);
    }
}
