<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\Scope;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = ['name', 'category_id', 'price_min', 'price_max', 'is_featured', 'is_active'];

    /**
     * Scope a query to only include active services.
     */
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * Scope a query to only include featured and active services.
     */
    #[Scope]
    protected function featured(Builder $query): void
    {
        $query->active()
            ->where('is_featured', true);
    }
}
