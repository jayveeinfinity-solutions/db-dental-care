<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'service_id',
        'scheduled_at',
        'status',
        'notes',
        'cancelled_by_id', 
        'cancellation_reason', 
        'cancelled_at'
    ];

    protected $appends = ['formatted_date'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
    
    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    public function cancelledBy()
    {
        return $this->belongsTo(User::class, 'cancelled_by_id');
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::parse($attributes['scheduled_at'])
                    ->format('F j, Y \a\t g:i A'),
        );
    }
}
