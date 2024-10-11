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
        'agencia', 'detalle', 'valor', 'fecha', 'tipo_documento', 'numero_documento', 'concepto',
        'tipo_tramite', 'nombre_tramite', 'nombre_entidad', 'movilizacion_tipo', 'viaticos',
        'combustible', 'destino', 'asignado', 'tipo_pasajes', 'subtipo_pasajes', 'tipo_fletes',
        'detalle_flete', 'movilizacion_destino', 'movilizacion_asignado', 'movilizacion_detalle',
        'comprobante', 'user_id', 'estado','novedad','inicio_destino','fin_destino','subtotal','tipo_mantenimiento',
        'hora_salida','hora_llegada'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function agencia()
    {
        return $this->belongsTo(Agencias::class);
    }
}
