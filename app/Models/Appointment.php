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
        'service_id',
        'user_id',
        'date',
        'status',
    ];

    protected $appends = ['formatted_date'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) =>
                Carbon::parse($attributes['date'])
                    ->timezone('Asia/Manila')
                    ->format('F j, Y \a\t g:i A'),
        );
    }
}
