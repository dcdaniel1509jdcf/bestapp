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
    public function __construct()
    {
        $this->middleware('permission:gasto-list|gasto-create|gasto-edit|gasto-delete', ['only' => ['index']]);
        $this->middleware('permission:gasto-create', ['only' => ['create','store']]);
        $this->middleware('permission:gasto-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:gasto-delete', ['only' => ['destroy']]);

    }
    public function index(Request $request)
    {

            $gastos=Gastos::all();
            return view('formularios.gastos.index', compact('gastos'));
    }

    public function create()
    {
        $agencias=Agencias::pluck('nombre','id');
        return view('formularios.gastos.create',compact('agencias'));
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
            'agencia_id' => 'required|exists:agencias,id',
            'fecha' => 'required|date',
            'concepto' => 'required|in:movilizacion,suministros,gastos_varios',
            'valor' => 'required_if:concepto,suministros,gastos_varios|nullable|numeric',
            'detalle' => 'required_if:concepto,suministros,gastos_varios|required_if:concepto,movilizacion|nullable|string',
            'numero_factura' => 'required_if:concepto,suministros,gastos_varios|required_if:concepto,movilizacion|nullable|string',
            'comprobante' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            'tipo_movilizacion' => 'required_if:concepto,movilizacion|nullable|string|in:volanteo,notificacion,traslado_valores,traslado_mercaderia,traslado_personal',
            'destino' => 'required_if:concepto,movilizacion|nullable|string',
            'asignado_a' => 'required_if:concepto,movilizacion|nullable|string',
        ]);



        // Obtener el depósito existente
        $gasto = Gastos::findOrFail($id);

        // Manejar la carga del archivo
        if ($request->hasFile('comprobante')) {
            // Eliminar el archivo anterior si existe
            if ($gasto->comprobante && Storage::disk('public')->exists($gasto->comprobante)) {
                Storage::disk('public')->delete($gasto->comprobante);
            }

            $filePath = $request->file('comprobante')->store('comprobantes/depositos', 'public');
            $gasto->comprobante = $filePath;
        }
        $gasto->agencia_id = $request->agencia_id;
        $gasto->fecha = $request->fecha;
        $gasto->concepto = $request->concepto;
        $gasto->valor = $request->valor;
        $gasto->detalle = $request->detalle;
        $gasto->numero_factura = $request->numero_factura;

        if ($request->concepto == 'movilizacion') {
            $gasto->tipo_movilizacion = $request->tipo_movilizacion;
            $gasto->destino = $request->destino;
            $gasto->asignado_a = $request->asignado_a;
        }
        // Guardar los cambios
        $gasto->save();

        // Redireccionar o responder según sea necesario
        return redirect()->route('gastos.index')->with('success', 'Gasto actualizado exitosamente');
    }
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'agencia_id' => 'required|exists:agencias,id',
            'fecha' => 'required|date',
            'concepto' => 'required|in:movilizacion,suministros,gastos_varios',
            'valor' => 'required_if:concepto,suministros,gastos_varios|nullable|numeric',
            'detalle' => 'required_if:concepto,suministros,gastos_varios|required_if:concepto,movilizacion|nullable|string',
            'numero_factura' => 'required_if:concepto,suministros,gastos_varios|required_if:concepto,movilizacion|nullable|string',
            'comprobante' => 'required|file|mimes:jpg,png,pdf|max:2048',
            'tipo_movilizacion' => 'required_if:concepto,movilizacion|nullable|string|in:volanteo,notificacion,traslado_valores,traslado_mercaderia,traslado_personal',
            'destino' => 'required_if:concepto,movilizacion|nullable|string',
            'asignado_a' => 'required_if:concepto,movilizacion|nullable|string',
        ]);

        // Manejo del archivo cargado
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes/gastos', 'public');
        }


        // Creación del gasto
        $gasto = new Gastos();
        $gasto->user_id = Auth::id();
        $gasto->agencia_id = $request->agencia_id;
        $gasto->fecha = $request->fecha;
        $gasto->concepto = $request->concepto;
        $gasto->valor = $request->valor;
        $gasto->detalle = $request->detalle;
        $gasto->numero_factura = $request->numero_factura;
        $gasto->comprobante = $comprobantePath;

        if ($request->concepto == 'movilizacion') {
            $gasto->tipo_movilizacion = $request->tipo_movilizacion;
            $gasto->destino = $request->destino;
            $gasto->asignado_a = $request->asignado_a;
        }

        // Guardar el gasto en la base de datos
        $gasto->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('gastos.index')->with('success', 'Gasto registrado correctamente.');
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

}
