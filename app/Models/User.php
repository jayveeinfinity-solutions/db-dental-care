<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $appends = ['is_password_default'];

    public function googleInfo()
    {
        return $this->hasOne(GoogleUserInfo::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    protected function isPasswordDefault(): Attribute
    {
        return Attribute::make(
            get: fn () => Hash::check('passwordfromgoogle', $this->password)
        );
    }
}
