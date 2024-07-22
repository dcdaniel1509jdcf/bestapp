<?php

namespace App\Models;

use App\Models\Formularios\Depositos;
use App\Models\Formularios\Gastos;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agencias extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'direccion', 'telefono','activo'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function depositos()
    {
        return $this->hasMany(Depositos::class, 'agencia_id');
    }
    public function gastos()
    {
        return $this->hasMany(Gastos::class);
    }
}

