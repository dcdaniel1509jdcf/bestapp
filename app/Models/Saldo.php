<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saldo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'tipo_saldo',
        'monto_asignado',
        'fecha_comprobante',
        'numero_recibo_factura',
        'comprobante',
        'valor',
        'numero_factura',
        'subtotal',
        'user_id',
    ];

}
