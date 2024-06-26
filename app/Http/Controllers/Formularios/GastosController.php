<?php

namespace App\Http\Controllers\Formularios;

use App\Http\Controllers\Controller;
use App\Models\Agencias;
use App\Models\Formularios\Gastos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GastosController extends Controller
{
    public function index(Request $request)
    {
/*
        if(auth()->user()->hasRole('ADMINISTRADOR')){
        $depositos = Depositos::orderBy('id', 'DESC')->get();
    }else if(auth()->user()->hasRole('TESORERIA')){
        $depositos = Depositos::orderBy('id', 'DESC')->where('tesoreria',null)->get();
    }else if(auth()->user()->hasRole('VENDEDOR')){
        $depositos = Depositos::orderBy('id', 'DESC')->whereNull('tesoreria')->orWhere('tesoreria','NEGADO')->whereNull('baja')->get();
    }else if(auth()->user()->hasRole('GESTOR DIFUSIONES')){
        $depositos = Depositos::orderBy('id', 'DESC')->where('tesoreria','CONFIRMADO')->whereNull('baja')->get();
    }
        return view('formularios.depositos.index', compact('depositos'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
            */
            $gastos=Gastos::all();
            return view('formularios.gastos.index', compact('gastos'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $agencias=Agencias::pluck('nombre','id');
        return view('formularios.gastos.create',compact('agencias'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'agencia_id'=> 'required',
            'fecha' => 'required',
            'concepto' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'observacion' => 'required|string|max:255',
            'fondo' => 'required|numeric',

            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:3048',
        ],
        [
            'agencia_id.required' => 'El campo Agencia es obligatorio.',
            'fecha.required' => 'El campo fecha de comprobante es obligatorio.',

            'concepto.required' => 'El campo Concepto es obligatorio.',
            'concepto.string' => 'El campo Concepto debe ser una cadena de texto.',
            'concepto.max' => 'El campo Concepto no puede tener más de 255 caracteres.',

            'observacion.required' => 'El campo Observacion es obligatorio.',
            'observacion.string' => 'El campo Observacion debe ser una cadena de texto.',
            'observacion.max' => 'El campo Observacion no puede tener más de 255 caracteres.',

            'valor.required' => 'El campo Valor es obligatorio.',
            'valor.numeric' => 'El campo Valor debe ser un número.',
            'fondo.required' => 'El campo Valor es obligatorio.',
            'fondo.numeric' => 'El campo Valor debe ser un número.',

            'comprobante.required' => 'El campo comprobante es obligatorio.',
            'comprobante.file' => 'El comprobante debe ser un archivo.',
            'comprobante.mimes' => 'El comprobante debe ser un archivo de tipo: jpg, jpeg, png, pdf.',
            'comprobante.max' => 'El comprobante no puede ser mayor de 3048 KB.',
        ]);

        // Manejar la carga del archivo
        if ($request->hasFile('comprobante')) {
            $filePath = $request->file('comprobante')->store('comprobantes/gastos', 'public');
        }

        // Guardar los datos en la base de datos
        Gastos::create([
            'fecha' => $request->fecha,
            'user_id' => Auth::id(),
            'agencia' => auth()->user()->agencia_id,
            //'origen' => $request->origen,
            'agencia_id' => $request->agencia_id,
            'fondo' => $request->fondo,
            'valor' => $request->valor,
            'concepto' => $request->concepto,
            'observacion' => $request->observacion,
            'comprobante' => $filePath,
        ]);

        return redirect()->route('gastos.index')->with('success', 'Gasto registrado exitosamente.');
    }
    public function edit($id)
    {
        $agencias=Agencias::pluck('nombre','id');
        $gasto = Gastos::find($id);
        return view('formularios.gastos.edit', compact('gasto','agencias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'agencia_id'=> 'required',
            'fecha' => 'required',
            'concepto' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'observacion' => 'required|string|max:255',
            'fondo' => 'required|numeric',

            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:3048',
        ],
        [
            'agencia_id.required' => 'El campo Agencia es obligatorio.',
            'fecha.required' => 'El campo fecha de comprobante es obligatorio.',

            'concepto.required' => 'El campo Concepto es obligatorio.',
            'concepto.string' => 'El campo Concepto debe ser una cadena de texto.',
            'concepto.max' => 'El campo Concepto no puede tener más de 255 caracteres.',

            'observacion.required' => 'El campo Observacion es obligatorio.',
            'observacion.string' => 'El campo Observacion debe ser una cadena de texto.',
            'observacion.max' => 'El campo Observacion no puede tener más de 255 caracteres.',

            'valor.required' => 'El campo Valor es obligatorio.',
            'valor.numeric' => 'El campo Valor debe ser un número.',
            'fondo.required' => 'El campo Valor es obligatorio.',
            'fondo.numeric' => 'El campo Valor debe ser un número.',

            'comprobante.required' => 'El campo comprobante es obligatorio.',
            'comprobante.file' => 'El comprobante debe ser un archivo.',
            'comprobante.mimes' => 'El comprobante debe ser un archivo de tipo: jpg, jpeg, png, pdf.',
            'comprobante.max' => 'El comprobante no puede ser mayor de 3048 KB.',
        ]);


        // Obtener el depósito existente
        $gastos = Gastos::findOrFail($id);

        // Manejar la carga del archivo
        if ($request->hasFile('comprobante')) {
            // Eliminar el archivo anterior si existe
            if ($gastos->comprobante && Storage::disk('public')->exists($gastos->comprobante)) {
                Storage::disk('public')->delete($gastos->comprobante);
            }

            $filePath = $request->file('comprobante')->store('comprobantes/depositos', 'public');
            $gastos->comprobante = $filePath;
        }
        $gastos->fecha = $request->fecha;
        $gastos->concepto = $request->concepto;
        $gastos->agencia_id = $request->agencia_id;
        $gastos->fondo = $request->fondo;
        $gastos->valor = $request->valor;
        $gastos->concepto = $request->concepto;
        $gastos->observacion = $request->observacion;
        // Guardar los cambios
        $gastos->save();

        // Redireccionar o responder según sea necesario
        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado exitosamente');
    }

}
