<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function create($userId)
    {
        $profile = UserProfile::where('user_id', $userId)->first();

        return view('admin.perfil.create', compact('profile', 'userId'));
    }
    public function upsert(Request $request, $userId)
    {
        // Validación de los datos entrantes
        $validatedData = $request->validate([
            'cedula' => 'required|string|unique:user_profiles,cedula,' . $userId . ',user_id',
            'banco' => 'required|string',
            'numero_cuenta' => 'required|string',
            'departamento' => 'required|string',
        ]);

        // Buscar al usuario
        $user = User::findOrFail($userId);
//
        // Usar updateOrCreate para crear o actualizar el perfil
        $profile = UserProfile::updateOrCreate(
            ['user_id' => $user->id], // Condición para buscar
            $validatedData // Datos para crear o actualizar
        );

        return redirect()->route('users.index')
                        ->with('success', 'Profil created/updated successfully');
    }
}
