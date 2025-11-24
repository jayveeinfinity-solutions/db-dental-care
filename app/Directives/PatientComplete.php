<?php

namespace App\Directives;

use Illuminate\Support\Facades\Blade;

class PatientComplete
{
    public static function register()
    {
        Blade::if('haspatient', function () {
            return auth()->check() && auth()->user()->patient !== null;
        });
    }
}
