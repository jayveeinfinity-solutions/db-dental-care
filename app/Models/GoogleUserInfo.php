<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoogleUserInfo extends Model
{
    use HasFactory;

    protected $table = 'google_users_info';

    protected $fillable = [
        'user_id',
        'google_id',
        'name',
        'email',
        'hd',
        'avatar',
        'locale',
        'access_token',
        'refresh_token',
        'expires_in'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
