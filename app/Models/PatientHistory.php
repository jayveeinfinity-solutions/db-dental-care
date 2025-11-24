<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientHistory extends Model
{
    protected $fillable = [
        'transaction_id',
        'patient_id',
        'file_path',
        'description'
    ];
}