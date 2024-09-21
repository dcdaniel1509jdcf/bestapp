<?php

namespace App\Http\Controllers\Formularios;

use App\Exports\GastosExport;
use App\Http\Controllers\Controller;
use App\Models\Agencias;
use App\Models\Formularios\Gastos;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GastosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:gasto-list|gasto-create|gasto-edit|gasto-delete', ['only' => ['index','index_jefatura']]);
        $this->middleware('permission:gasto-create', ['only' => ['create','store']]);
        $this->middleware('permission:gasto-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:gasto-delete', ['only' => ['destroy']]);
        //$this->middleware('permission:gasto-show', ['only' => ['show']]);
        $this->middleware('permission:gasto-authorize', ['only' => ['show','authorize']]);

    }
    public function index(Request $request)
    {

        $gastos=null;
        // Iniciar la consulta base
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $jefes = User::role('JEFATURA')->get();
            $gastos = Gastos::whereNotIn('user_id', $jefes->pluck('id')) // Filtrar por los IDs de los usuarios con rol JEFATURA
               ->orderBy('id', 'DESC')->get();

        }elseif (auth()->user()->hasRole('TESORERIA HOLDING')) {
            $jefes = User::role('JEFATURA')->get();
            $gastos = Gastos::whereIn('estado', [1, 4, 7])
               ->whereIn('user_id', $jefes->pluck('id')) // Filtrar por los IDs de los usuarios con rol JEFATURA
               ->orderBy('id', 'DESC')->get();

        } elseif (auth()->user()->hasRole('CAJERO GASTOS')) {
            $query = Gastos::query();
            $query->where('user_id', auth()->user()->id)
                  ->where(function ($subQuery) {
                      $subQuery->whereIn('estado', [1,2,3,6]);
                  })
                  ->orderBy('id', 'DESC');
            $gastos = $query->get();
        }
        return view('formularios.gastos.index', compact('gastos'));
    }
    public function index_jefatura(Request $request)
    {
        $gastos=null;
        // Iniciar la consulta base
        if (auth()->user()->hasRole('ADMINISTRADOR')) {
            $jefes = User::role('JEFATURA')->get();
            $gastos = Gastos::whereIn('user_id', $jefes->pluck('id')) // Filtrar por los IDs de los usuarios con rol JEFATURA
               ->orderBy('id', 'DESC')->get();

        }elseif (auth()->user()->hasRole('TESORERIA HOLDING')) {
            $jefes = User::role('JEFATURA')->get();
            $gastos = Gastos::whereIn('estado', [1, 4, 7])
               ->whereIn('user_id', $jefes->pluck('id')) // Filtrar por los IDs de los usuarios con rol JEFATURA
               ->orderBy('id', 'DESC')->get();

        } elseif (auth()->user()->hasRole('JEFATURA')) {
            $query = Gastos::query();
            $query->where('user_id', auth()->user()->id)
                  ->where(function ($subQuery) {
                      $subQuery->whereIn('estado', [2,3,6,7]);
                  })
                  ->orderBy('id', 'DESC');
            $gastos = $query->get();
        }



// Recorrer cada usuario y buscar en la tabla de gastos los registros con estado 1, 2, o 3

        return view('formularios.gastos.index_jefatura', compact('gastos'));
    }

    public function create()
    {

            $agencia =auth()->user()->agencia->nombre;
        if(auth()->user()->agencia->nombre == "AREA"){
            $agencia =auth()->user()->profile->departamento;
            return view('formularios.gastos.create_area', compact('agencia'));
        }else{
            return view('formularios.gastos.create', compact('agencia'));
        }
    }

    public function edit($id)
    {
        $agencias = Agencias::pluck('nombre', 'id');
        $gasto = Gastos::find($id);
        return view('formularios.gastos.edit', compact('gasto', 'agencias'));
    }

    public function update(Request $request, $id)
    {
        $gasto = Gastos::findOrFail($id);
        $request->validate([
            'agencia' => 'required|string|max:255',
            'detalle' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
           // 'fecha' => 'required|date',
           //'tipo_documento' => 'required|string',
           // 'comprobante' => 'required|file|mimes:jpg,png,pdf|max:2048',
           // 'numero_documento' => 'nullable|string|max:255',
            //'concepto' => 'required|string',

            // Validar campos condicionales según el concepto seleccionado
            'tipo_tramite' => 'nullable|required_if:concepto,tramites_entidades|string',
            'nombre_tramite' => 'nullable|required_if:concepto,tramites_entidades|string|max:255',
            'nombre_entidad' => 'nullable|required_if:concepto,tramites_entidades|string|max:255',
            'movilizacion_tipo' => 'nullable|required_if:concepto,movilizacion|string',
            'viaticos' => 'nullable|required_if:movilizacion_tipo,viaticos|string',
            'combustible' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'asignado' => 'nullable|string|max:255',
            'tipo_pasajes' => 'nullable|string|max:255',
            'subtipo_pasajes' => 'nullable|string|max:255',
            'tipo_fletes' => 'nullable|string|max:255',
            'detalle_flete' => 'nullable|string|max:1000',
            'movilizacion_destino' => 'nullable|string|max:255',
            'movilizacion_asignado' => 'nullable|string|max:255',
            'movilizacion_detalle' => 'nullable|string|max:1000',
        ]);

        // Procesar la carga del archivo de comprobante
        if ($request->hasFile('comprobante')) {
            // Eliminar el archivo anterior si existe
            if ($gasto->comprobante && Storage::disk('public')->exists($gasto->comprobante)) {
                Storage::disk('public')->delete($gasto->comprobante);
            }

            $filePath = $request->file('comprobante')->store('comprobantes/gastos', 'public');
            $gasto->comprobante = $filePath;
        }

        // actualizar una nueva instancia del modelo Gasto

        $gasto->agencia = $request->agencia;
        $gasto->detalle = $request->detalle;
        $gasto->valor = $request->valor;

        $gasto->fecha = $request->fecha;
        $gasto->tipo_documento = $request->tipo_documento;
        $gasto->numero_documento = $request->numero_documento;
        $gasto->concepto = $request->concepto;

//campos reiniciados
            $gasto->tipo_tramite = null;
            $gasto->nombre_tramite = null;
            $gasto->nombre_entidad = null;
            $gasto->movilizacion_tipo = null;
            $gasto->viaticos = null;
            $gasto->combustible = null;
            $gasto->destino = null;
            $gasto->asignado = null;
            $gasto->tipo_pasajes = null;
            $gasto->subtipo_pasajes = null;
            $gasto->tipo_fletes = null;
            $gasto->detalle_flete = null;
            $gasto->movilizacion_destino = null;
            $gasto->movilizacion_asignado = null;
            $gasto->movilizacion_detalle = null;

        // Campos condicionales según el concepto
        if ($request->concepto == 'tramites_entidades') {
            $gasto->tipo_tramite = $request->tipo_tramite;
            $gasto->nombre_tramite = $request->nombre_tramite;
            $gasto->nombre_entidad = $request->nombre_entidad;

        } elseif ($request->concepto == 'movilizacion') {
            $gasto->movilizacion_tipo = $request->movilizacion_tipo;
            $gasto->viaticos = $request->viaticos;
            if ($request->movilizacion_tipo=="viaticos"){
                if ($request->viaticos=="fletes") {
                    $gasto->tipo_fletes = $request->tipo_fletes;
                    $gasto->detalle_flete = $request->detalle_flete;
                }else if ($request->viaticos=="pasaje") {
                    $gasto->tipo_pasajes = $request->tipo_pasajes;
                    $gasto->subtipo_pasajes = $request->subtipo_pasajes;
                } elseif ($request->viaticos == "peaje") {
                    $gasto->destino = $request->destino;
                    $gasto->asignado = $request->asignado;
                    $gasto->combustible = $request->combustible;
                }
            } else if($request->movilizacion_tipo !="mantenimiento" ) {
                $gasto->movilizacion_destino = $request->movilizacion_destino;
                $gasto->movilizacion_asignado = $request->movilizacion_asignado;
                $gasto->movilizacion_detalle = $request->movilizacion_detalle;

            }

        } elseif ($request->concepto == 'suministros' || $request->concepto == 'gastos_varios') {

            $gasto->tipo_tramite = null;
            $gasto->nombre_tramite = null;
            $gasto->nombre_entidad = null;

            $gasto->movilizacion_tipo = null;
            $gasto->viaticos = null;
            $gasto->combustible = null;
            $gasto->destino = null;
            $gasto->asignado = null;
            $gasto->tipo_pasajes = null;
            $gasto->subtipo_pasajes = null;
            $gasto->tipo_fletes = null;
            $gasto->detalle_flete = null;
            $gasto->movilizacion_destino = null;
            $gasto->movilizacion_asignado = null;
            $gasto->movilizacion_detalle = null;
        }
        // Guardar la ruta del comprobante si existe


        $gasto->user_id = auth()->user()->id;
        if (auth()->user()->hasRole('JEFATURA')) {
            $gasto->estado = 4;
            $gasto->novedad= null;
        }
        if (auth()->user()->hasRole('CAJERO GASTOS')) {
            $gasto->estado = 4;
            $gasto->novedad= null;
        }

        // Guardar el registro del gasto en la base de datos
        $gasto->save();
        if (auth()->user()->hasRole('JEFATURA')) {
            return redirect()->route('gastos.index.jefatura')->with('success', 'Gasto actualizado exitosamente');
        }else{
            return redirect()->route('gastos.index')->with('success', 'Gasto actualizado exitosamente');
        }
    }
    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'agencia' => 'required|string|max:255',
            'detalle' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
           // 'fecha' => 'required|date',
           //'tipo_documento' => 'required|string',
           // 'comprobante' => 'required|file|mimes:jpg,png,pdf|max:2048',
           // 'numero_documento' => 'nullable|string|max:255',
            //'concepto' => 'required|string',

            // Validar campos condicionales según el concepto seleccionado
            'tipo_tramite' => 'nullable|required_if:concepto,tramites_entidades|string',
            'nombre_tramite' => 'nullable|required_if:concepto,tramites_entidades|string|max:255',
            'nombre_entidad' => 'nullable|required_if:concepto,tramites_entidades|string|max:255',
            'movilizacion_tipo' => 'nullable|required_if:concepto,movilizacion|string',
            'viaticos' => 'nullable|required_if:movilizacion_tipo,viaticos|string',
            'combustible' => 'nullable|string|max:255',
            'destino' => 'nullable|string|max:255',
            'asignado' => 'nullable|string|max:255',
            'tipo_pasajes' => 'nullable|string|max:255',
            'subtipo_pasajes' => 'nullable|string|max:255',
            'tipo_fletes' => 'nullable|string|max:255',
            'detalle_flete' => 'nullable|string|max:1000',
            'movilizacion_destino' => 'nullable|string|max:255',
            'movilizacion_asignado' => 'nullable|string|max:255',
            'movilizacion_detalle' => 'nullable|string|max:1000',
        ]);

        // Procesar la carga del archivo de comprobante
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes/gastos', 'public');
        }

        // Crear una nueva instancia del modelo Gasto
        $gasto = new Gastos();
        $gasto->agencia = $request->agencia;
        $gasto->detalle = $request->detalle;
        $gasto->valor = $request->valor;
        $gasto->fecha = $request->fecha;
        $gasto->tipo_documento = $request->tipo_documento;
        $gasto->numero_documento = $request->numero_documento;
        $gasto->concepto = $request->concepto;

        // Campos condicionales según el concepto
        if ($request->concepto == 'tramites_entidades') {
            $gasto->tipo_tramite = $request->tipo_tramite;
            $gasto->nombre_tramite = $request->nombre_tramite;
            $gasto->nombre_entidad = $request->nombre_entidad;
        } elseif ($request->concepto == 'movilizacion') {
            $gasto->movilizacion_tipo = $request->movilizacion_tipo;
            $gasto->viaticos = $request->viaticos;
            $gasto->combustible = $request->combustible;
            $gasto->destino = $request->destino;
            $gasto->asignado = $request->asignado;
            $gasto->tipo_pasajes = $request->tipo_pasajes;
            $gasto->subtipo_pasajes = $request->subtipo_pasajes;
            $gasto->tipo_fletes = $request->tipo_fletes;
            $gasto->detalle_flete = $request->detalle_flete;
            $gasto->movilizacion_destino = $request->movilizacion_destino;
            $gasto->movilizacion_asignado = $request->movilizacion_asignado;
            $gasto->movilizacion_detalle = $request->movilizacion_detalle;
        }

        // Guardar la ruta del comprobante si existe
        if (isset($comprobantePath)) {
            $gasto->comprobante = $comprobantePath;
        }

        $gasto->user_id = auth()->user()->id;
        if (auth()->user()->hasRole('JEFATURA')) {
            $gasto->estado = 7;
        }
        if (auth()->user()->hasRole('CAJERO GASTOS')) {
            $gasto->estado = 1;
        }

        // Guardar el registro del gasto en la base de datos
        $gasto->save();

        if (auth()->user()->hasRole('JEFATURA')) {
            return redirect()->route('gastos.index.jefatura')->with('success', 'El gasto ha sido registrado exitosamente');
        }else{
            return redirect()->route('gastos.index')->with('success', 'El gasto ha sido registrado exitosamente.');
        }
        // Redirigir con un mensaje de éxito

    }

    public function destroy($id)
    {
        // Encontrar el depósito por su ID
        $gasto = Gastos::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if ($gasto->comprobante) {
            Storage::disk('public')->delete($gasto->comprobante);
        }

        // Eliminar el depósito (soft delete)
        $gasto->delete();

        return redirect()->route('gastos.index')->with('success', 'Gasto eliminado exitosamente.');
    }
    public function download(Request $request)
    {
       // return Excel::download(new GastosExport($request->dateIni, $request->dateFin), 'gastos'.time().'.xlsx');
        return "En Proceso Att. DC";
    }
    public function show($id)
    {
        $gasto = Gastos::with('agencia')->findOrFail($id);
        return view('formularios.gastos.show', compact('gasto'));
    }

    public function autorizate(Request $request, $id)
    {
        $request->validate([
            //'tesoreria' => 'required|string|max:255',
            'estado' => 'required',
            //'cajas' => 'nullable|string|max:255',
            //'novedad' => 'nullable|string|max:255',
        ]);

        $gasto = Gastos::findOrFail($id);
        //$deposito->tesoreria = $request->tesoreria;
        //$deposito->user_tesoreria = Auth::id();
        $gasto->estado = $request->estado;
        //$deposito->cajas = $request->cajas;
        $gasto->novedad = $request->novedad;
        $gasto->save();

        return redirect()->back()->with('success', 'Gasto actualizado exitosamente');
    }

}
