<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agencias;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $agencias = Agencias::where('activo',true)->pluck('nombre', 'id');

        return view('admin.users.create', compact('roles','agencias'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'agencia_id' => 'nullable|exists:agencias,id',
        ],
        [
            'password.required' => 'La contraseña es requerida.',
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.unique' => 'El email ya está en uso por otro usuario.',
            'password.same' => 'La confirmación de la contraseña no coincide.',
            'roles.required' => 'El campo roles es obligatorio.',
            'agencia_id.exists' => 'La agencia seleccionada no es válida.',
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = User::find($id);
        $agencias = Agencias::pluck('nombre', 'id');
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole','agencias'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required',
            'agencia_id' => 'nullable|exists:agencias,id',
            'active' => 'required|boolean',
        ],
        [
            'name.required' => 'El campo nombre es obligatorio.',
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo válida.',
            'email.unique' => 'El email ya está en uso por otro usuario.',
            'password.same' => 'La confirmación de la contraseña no coincide.',
            'roles.required' => 'El campo roles es obligatorio.',
            'agencia_id.exists' => 'La agencia seleccionada no es válida.',
            'active.required' => 'El campo visibilidad de usuario es obligatorio.',
        ]);

        $input = $request->all();
        if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success', 'User updated successfully');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }
    public function showChangePasswordForm(){
        $user=Auth::user();
        return view('admin.users.profil', compact('user'));
    }
    public function changePassword(Request $request)
    {
        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|same:confirm-password',
        ],
        [
            'current_password.required' => 'La contraseña actual es requerida.',
            'password.required' => 'La nueva contraseña es requerida.',
            'password.string' => 'La nueva contraseña debe ser una cadena de texto.',
            'password.min' => 'La nueva contraseña debe tener al menos :min caracteres.',
            'password.same' => 'La confirmación de la nueva contraseña no coincide.',
        ]);


        // Verificar si la validación falla
        if ($validator->fails()) {
            return redirect()->route('change.password.user',['user'=>Auth::id()])
                        ->withErrors($validator)
                        ->withInput();
        }

        // Verificar la contraseña actual
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('change.password.user',['user'=>Auth::id()])
                        ->withErrors(['current_password' => 'La contraseña actual no es válida'])
                        ->withInput();
        }

        // Cambiar la contraseña
        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->save();

        // Redireccionar con mensaje de éxito
        return redirect()->route('home')->with('success', '¡Contraseña cambiada correctamente!');
    }
}
