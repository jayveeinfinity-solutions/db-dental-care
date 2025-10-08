<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = ['name', 'category_id', 'price_min', 'price_max', 'is_featured', 'is_active'];

    public function scopeActive($query) {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query) {
        return $query->active()
            ->where('is_featured', true);
    }
}
