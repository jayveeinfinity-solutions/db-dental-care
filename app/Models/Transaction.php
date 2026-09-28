<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    protected $fillable = [
        'appointment_id', 
        'patient_id',
        'total_amount',
        'status',
        'checked_in_at',
        'checked_out_at',
        'duration_seconds',
        'notes'
    ];

    protected $casts = [
        'checked_in_at' => 'datetime',
        'checked_out_at' => 'datetime',
    ];

    protected $appends = ['formatted_date', 'formatted_duration', 'formatted_check_in', 'formatted_check_out'];
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function services()
    {
        return $this->hasMany(TransactionService::class);
    }

    public function history()
    {
        return $this->hasOne(PatientHistory::class, 'transaction_id');
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::parse($attributes['created_at'])
                    ->format('F j, Y g:i A'),
        );
    }

    protected function formattedDuration(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $seconds = $attributes['duration_seconds'] ?? null;
                if ($seconds === null) {
                    if (!empty($attributes['checked_in_at']) && empty($attributes['checked_out_at'])) {
                        $seconds = Carbon::parse($attributes['checked_in_at'])->diffInSeconds(now());
                    } else {
                        return null;
                    }
                }
                
                $hours = floor($seconds / 3600);
                $minutes = floor(($seconds % 3600) / 60);
                $secs = $seconds % 60;

                if ($hours > 0) {
                    return "{$hours}h {$minutes}m";
                }
                if ($minutes > 0) {
                    return "{$minutes}m {$secs}s";
                }
                return "{$secs}s";
            },
        );
    }

    protected function formattedCheckIn(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                !empty($attributes['checked_in_at'])
                    ? Carbon::parse($attributes['checked_in_at'])->format('F j, Y g:i A')
                    : null,
        );
    }

    protected function formattedCheckOut(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                !empty($attributes['checked_out_at'])
                    ? Carbon::parse($attributes['checked_out_at'])->format('F j, Y g:i A')
                    : null,
        );
    }
}
