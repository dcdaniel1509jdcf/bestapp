<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Formularios\Depositos;
use App\Models\Formularios\Gastos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'agencia_id',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function depositos()
    {
        return $this->hasMany(Depositos::class, 'user_id');
    }

    public function depositosTesoreria()
    {
        return $this->hasMany(Depositos::class, 'user_tesoreria');
    }

    public function agencia()
    {
        return $this->belongsTo(Agencias::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
    public function gastos()
    {
        return $this->hasMany(Gastos::class, 'user_id');
    }
}
