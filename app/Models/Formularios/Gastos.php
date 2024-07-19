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
            'fecha',
            'concepto',
            'valor',
            'detalle',
            'numero_factura',
            'comprobante',
            'tipo_movilizacion',
            'destino',
            'asignado_a',
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
