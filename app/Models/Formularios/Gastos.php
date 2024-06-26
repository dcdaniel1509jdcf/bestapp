<?php

namespace App\Models\Formularios;

use App\Models\Agencias;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gastos extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'agencia_id',
        'fondo',
        'agencia',
        'concepto',
        'valor',
        'observacion',
        'comprobante',
        'fecha',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agenciaN()
    {
        return $this->belongsTo(Agencias::class, 'agencia_id');
    }
}
