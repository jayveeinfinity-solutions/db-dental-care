<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}