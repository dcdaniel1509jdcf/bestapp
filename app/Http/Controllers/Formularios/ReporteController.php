<?php

namespace App\Http\Controllers\Formularios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(){
        return view('formularios.descargas.index');
    }
    public function index_gastos(){
        return view('formularios.descargas.index_gastos');
    }

}
