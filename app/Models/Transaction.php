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
        'total_amount'
    ];

    protected $appends = ['formatted_date'];
    
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
}
