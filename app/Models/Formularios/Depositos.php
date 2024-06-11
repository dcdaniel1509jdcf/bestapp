<?php

namespace App\Models\Formularios;

use App\Models\Agencias;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Depositos extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'agencia_id',
        'user_tesoreria',
        'apellidos',
        'nombres',
        'origen',
        'num_documento',
        'val_deposito',
        'banco',
        'num_credito',
        'comprobante',
        'tesoreria',
        'cajas',
        'baja',
        'novedad',
        'fecha',
        'tesoreria',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function usertesoreria()
    {
        return $this->belongsTo(User::class, 'user_tesoreria');
    }
    public function agencia()
    {
        return $this->belongsTo(Agencias::class, 'agencia_id');
    }
}
