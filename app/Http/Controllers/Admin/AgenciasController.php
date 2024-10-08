<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agencias;
use Illuminate\Http\Request;

class AgenciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:agencia-list|agencia-create|agencia-edit|agencia-delete', ['only' => ['index']]);
        $this->middleware('permission:agencia-create', ['only' => ['create','store']]);
        $this->middleware('permission:agencia-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:agencia-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $agencias = Agencias::all();
        return view('admin.agencias.index', compact('agencias'));
    }

    public function create()
    {
        return view('admin.agencias.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
            'nombre' => 'required|unique:agencias|max:255',
            'telefono' => 'required|digits:10',
        ],
            [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
        ]
        );

        Agencias::create(['nombre' => $request->nombre,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'activo' => true]);

        return redirect()->route('agencias.index')->with('success', 'Agencia created successfully.');
    }

    public function edit(Agencias $agencia)
    {
        return view('admin.agencias.edit', compact('agencia'));
    }

    public function update(Request $request, Agencias $agencia)
    {
        $request->validate(
            [
            'nombre' => 'required|unique:agencias,nombre,' . $agencia->id . '|max:255',
            'telefono' => 'required|digits:10',
            'activo' => 'required|boolean',
        ],
            [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.unique' => 'El nombre ya está en uso.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
            'activo.boolean' => 'El campo activo de agencia incorrecto.',
            'activo.required' => 'El campo activo es obligatorio.',
        ]
        );

        $agencia->update(['nombre' => $request->nombre,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'activo' => $request->activo]);

        return redirect()->route('agencias.index')->with('success', 'Agencia updated successfully.');
    }

    public function destroy(Agencias $agencia)
    {
        $agencia->delete();

        return redirect()->route('agencias.index')->with('success', 'Agencia deleted successfully.');
    }
}
