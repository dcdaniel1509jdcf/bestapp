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
    public function reposicion_gastos_bestpc(){
        return view('formularios.descargas.indexReposicionBestPC');
    }
    public function index_gastos_general(){
        return view('formularios.descargas.indexGastosGeneral');
    }
}
