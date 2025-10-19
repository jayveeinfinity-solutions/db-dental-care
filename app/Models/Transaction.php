<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['appointment_id', 'total_amount'];
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function services()
    {
        return $this->hasMany(TransactionService::class);
    }
}
