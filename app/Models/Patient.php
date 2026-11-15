<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'first_name',
        'middle_name',
        'last_name',
        'birthdate',
        'sex',
        'contact_number',
        'address'
    ];

    protected $appends = ['full_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function procedures()
    {
        return $this->hasMany(PatientProcedure::class)->orderBy('procedure_date', 'desc');
    }

    public function histories()
    {
        return $this->hasMany(PatientHistory::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => trim(
                ($attributes['last_name'] ?? '') . ', ' .
                ($attributes['first_name'] ?? '') . ' ' .
                (
                    !empty($attributes['middle_name'])
                        ? strtoupper($attributes['middle_name'][0]) . '.'
                        : ''
                )
            )
        );
    }
}