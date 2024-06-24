<?php

namespace App\Http\Controllers\Formularios;

use App\Exports\DepositosExport;
use App\Http\Controllers\Controller;
use App\Models\Formularios\Depositos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class DepositosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:deposito-list|deposito-create|deposito-edit|deposito-delete|deposito->authorize', ['only' => ['index']]);
        $this->middleware('permission:deposito-create', ['only' => ['create','store']]);
        $this->middleware('permission:deposito-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:deposito-delete', ['only' => ['destroy']]);
        $this->middleware('permission:deposito-authorize', ['only' => ['show','authorize']]);
    }
    public function index(Request $request)
    {

        if(auth()->user()->hasRole('ADMINISTRADOR')){
        $depositos = Depositos::orderBy('id', 'DESC')->paginate(5);
    }else if(auth()->user()->hasRole('TESORERIA')){
        $depositos = Depositos::orderBy('id', 'DESC')->where('tesoreria',null)->paginate(5);
    }else if(auth()->user()->hasRole('VENDEDOR')){
        $depositos = Depositos::orderBy('id', 'DESC')->whereNull('tesoreria')->orWhere('tesoreria','NEGADO')->whereNull('baja')->paginate(5);
    }else if(auth()->user()->hasRole('GESTOR DIFUSIONES')){
        $depositos = Depositos::orderBy('id', 'DESC')->where('tesoreria','CONFIRMADO')->whereNull('baja')->paginate(5);
    }
        return view('formularios.depositos.index', compact('depositos'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        return view('formularios.depositos.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'apellidos' => 'required|string|max:255',
            //'nombres' => 'required|string|max:255',
            'origen' => 'required',
            'fecha' => 'required',
            'num_documento' => 'required|string|max:255|unique:depositos,num_documento',
            'val_deposito' => 'required|numeric',
            'banco' => 'required|string|max:255',
            'num_credito' => 'required|string|max:255',
            'comprobante' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Manejar la carga del archivo
        if ($request->hasFile('comprobante')) {
            $filePath = $request->file('comprobante')->store('comprobantes', 'public');
        }

        // Guardar los datos en la base de datos
        Depositos::create([
            'fecha' => $request->fecha,
            'user_id' => Auth::id(),
            'origen' => $request->origen,
            'agencia_id' => auth()->user()->agencia_id,
            'apellidos' => $request->apellidos,
            'nombres' => $request->nombres ?? '-',
            'num_documento' => $request->num_documento,
            'val_deposito' => $request->val_deposito,
            'banco' => $request->banco,
            'num_credito' => $request->num_credito,
            'comprobante' => $filePath,
        ]);

        return redirect()->route('depositos.index')->with('success', 'Depósito registrado exitosamente.');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'apellidos' => 'required|string|max:255',
            //'nombres' => 'required|string|max:255',
            'origen' => 'required',
            'fecha' => 'required',
            'num_documento' => [
                'required',
                'string',
                'max:255',
                Rule::unique('depositos', 'num_documento')->ignore($id),
            ],
            'val_deposito' => 'required|numeric',
            'banco' => 'required|string|max:255',
            'num_credito' => 'required|string|max:255',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Obtener el depósito existente
        $deposito = Depositos::findOrFail($id);

        // Manejar la carga del archivo
        if ($request->hasFile('comprobante')) {
            // Eliminar el archivo anterior si existe
            if ($deposito->comprobante && Storage::disk('public')->exists($deposito->comprobante)) {
                Storage::disk('public')->delete($deposito->comprobante);
            }

            $filePath = $request->file('comprobante')->store('comprobantes', 'public');
            $deposito->comprobante = $filePath;
        }

        // Actualizar los datos en la base de datos
        $deposito->fecha = $request->fecha;
        //$deposito->user_id = Auth::id();
        $deposito->origen = $request->origen;
        //$deposito->agencia_id = auth()->user()->agencia_id;
        $deposito->apellidos = $request->apellidos;
        $deposito->nombres = $request->nombres ?? '-';
        $deposito->num_documento = $request->num_documento;
        $deposito->val_deposito = $request->val_deposito;
        $deposito->banco = $request->banco;
        $deposito->num_credito = $request->num_credito;
        if(auth()->user()->hasPermissionTo('deposito-authorize')) {
            $deposito->tesoreria = $request->tesoreria;
            $deposito->user_tesoreria = Auth::id();
            $deposito->cajas = $request->cajas;
            $deposito->novedad = $request->novedad;
        }
        // Guardar los cambios
        $deposito->save();

        // Redireccionar o responder según sea necesario
        return redirect()->route('depositos.index')->with('success', 'Depósito actualizado exitosamente');
    }
    public function edit($id)
    {
        $deposito = Depositos::find($id);
        return view('formularios.depositos.edit', compact('deposito'));
    }
    public function destroy($id)
    {
        // Encontrar el depósito por su ID
        $deposito = Depositos::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if ($deposito->comprobante) {
            Storage::disk('public')->delete($deposito->comprobante);
        }

        // Eliminar el depósito (soft delete)
        $deposito->delete();

        return redirect()->route('depositos.index')->with('success', 'Depósito eliminado exitosamente.');
    }
    public function download(Request $request)
    {
        return Excel::download(new DepositosExport($request->dateIni, $request->dateFin), 'depositos.xlsx');
        //return $request;
    }
    public function show($id)
    {
        $deposito = Depositos::findOrFail($id);
        return view('formularios.depositos.show', compact('deposito'));
    }
    public function autorizate(Request $request, $id)
    {
        $request->validate([
            //'tesoreria' => 'required|string|max:255',
            'baja' => 'required|string|max:255',
            //'cajas' => 'nullable|string|max:255',
            //'novedad' => 'nullable|string|max:255',
        ]);

        $deposito = Depositos::findOrFail($id);
        //$deposito->tesoreria = $request->tesoreria;
        //$deposito->user_tesoreria = Auth::id();
        $deposito->baja = $request->baja;
        //$deposito->cajas = $request->cajas;
        //$deposito->novedad = $request->novedad;
        $deposito->save();

        return redirect()->route('depositos.index')->with('success', 'Depósito actualizado exitosamente');
    }
}
