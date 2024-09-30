<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'date',
        'status',
        'student_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($attendance) {
            $schedule = $attendance->schedule;
            if (!$schedule) {
                throw new \Exception("The associated Schedule does not exist.");
            }

            $dayOfWeek = Carbon::parse($attendance->date)->dayOfWeek;
            $scheduleDayOfWeek = array_search(strtolower($schedule->day_of_week), ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);

            if ($dayOfWeek !== $scheduleDayOfWeek) {
                throw new \Exception("The date does not match the day of the week of the Schedule.");
            }
        });
    }
}
