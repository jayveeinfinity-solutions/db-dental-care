<?php

namespace App\Services;

use App\Models\Service;

class DentalService
{
    public function __construct(

    ) {}

    public function get() {
        return Service::with('category')
            ->active()
            ->orderBy('category_id')
            ->orderBy('name')
            ->get();
    }
}