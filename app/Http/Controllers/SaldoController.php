<?php

namespace App\Http\Controllers;

use App\Models\Saldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaldoController extends Controller
{
    public function index()
    {
        $saldos = Saldo::all(); // You may want to add pagination or sorting here
        return view('formularios.gastos.gestion.index_gestion', compact('saldos'));
    }

    public function create()
    {
        return view('formularios.gastos.gestion.gestion'); // Replace with your view name
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_saldo' => 'required|string',
            'monto_asignado' => 'nullable|numeric',
            'fecha_comprobante' => 'required|date',
            'numero_recibo_factura' => 'required|string',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'valor' => 'required|numeric',
            'numero_factura' => 'nullable|string',
            'subtotal' => 'nullable|numeric',
        ]);

        // Handle file upload
        $comprobantePath = null;
        if ($request->hasFile('comprobante')) {
            $comprobantePath = $request->file('comprobante')->store('comprobantes/gestion', 'public');
        }

        // Create saldo record
       // return $request->all();
        Saldo::create(array_merge($request->all(), [
            'comprobante' => $comprobantePath,
            'user_id' => auth()->id(), // assuming the user is authenticated
        ]));

        return redirect()->back()->with('success', 'Saldo guardado correctamente.');
    }
    public function edit($id)
    {
        $saldo = Saldo::findOrFail($id);
        return view('formularios.gastos.gestion.edit', compact('saldo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_saldo' => 'required|string',
            'monto_asignado' => 'required|numeric',
            'fecha_comprobante' => 'required|date',
            'numero_recibo_factura' => 'required|string',
            'valor' => 'required|numeric',
            'numero_factura' => 'nullable|string',
            'subtotal' => 'nullable|numeric',
            'comprobante' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // Adjust file validation as needed
        ]);

        $saldo = Saldo::findOrFail($id);
        $saldo->tipo_saldo = $request->tipo_saldo;
        $saldo->monto_asignado = $request->monto_asignado;
        $saldo->fecha_comprobante = $request->fecha_comprobante;
        $saldo->numero_recibo_factura = $request->numero_recibo_factura;
        $saldo->valor = $request->valor;
        $saldo->numero_factura = $request->numero_factura;
        $saldo->subtotal = $request->subtotal;

        // Handle file upload if a new file is provided
        if ($request->hasFile('comprobante')) {
            if ($saldo->comprobante && Storage::disk('public')->exists($saldo->comprobante)) {
                Storage::disk('public')->delete($saldo->comprobante);
            }
            // Store the file and update the path
            $filePath = $request->file('comprobante')->store('comprobantes/gestion', 'public');
            $saldo->comprobante = $filePath;
        }

        $saldo->save();

        return redirect()->route('saldos.index')->with('success', 'Saldo actualizado correctamente.');
    }

    public function destroy($id)
    {
        // Encontrar el depósito por su ID
        $saldo = saldo::findOrFail($id);

        // Eliminar el archivo asociado si existe
        if ($saldo->comprobante) {
            Storage::disk('public')->delete($saldo->comprobante);
        }

        // Eliminar el saldo (soft delete)
        $saldo->delete();

        return redirect()->route('saldos.index')->with('success', 'Saldo eliminado exitosamente.');
    }
}
