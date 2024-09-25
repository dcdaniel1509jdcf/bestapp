<?php

use App\Http\Controllers\Admin\AgenciasController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Formularios\DepositosController;
use App\Http\Controllers\Formularios\GastosController;
use App\Http\Controllers\Formularios\ReporteController;
use App\Http\Controllers\SaldoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();



Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
        return Redirect()->route('home');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::get('/cambiar-contrasena', [UserController::class, 'showChangePasswordForm'])->name('change.password.user');
    Route::post('/cambiar-contrasena', [UserController::class,'changePassword'])->name('change.password.user.post');
    Route::resource('permissions', PermissionController::class);
    Route::resource('depositos', DepositosController::class);
    Route::resource('agencias', AgenciasController::class);
    Route::resource('gastos', GastosController::class);
    //Route::resource('agencias', AgenciasController::class);


    Route::post('depositos-download', [DepositosController::class, 'download'])->name('depositos.download');
    Route::post('gastos-download', [GastosController::class, 'download'])->name('gastos.download');
    Route::post('/filtrar', [DepositosController::class, 'filtrar'])->name('filtrar');
    Route::patch('depositos-autorizacion/{deposito}', [DepositosController::class, 'autorizate'])->name('depositos.autorizacion');

    Route::resource('reportes', ReporteController::class);
    Route::get('/reportes-gastos', [ReporteController::class, 'index_gastos'])->name('reportes.gastos.index');

    Route::get('/depositos-buscar', [DepositosController::class, 'buscar'])->name('depositos.search');
    Route::get('/depositos-buscar-show/{deposito}', [DepositosController::class, 'edit_adm'])->name('depositos.edit.adm');
    Route::patch('/depositos-buscar-update/{deposito}', [DepositosController::class, 'update_adm'])->name('depositos.update.adm');
    // Route::resource('productos', ProductController::class);

    Route::get('/user/{userId}/profile/create', [UserProfileController::class, 'create'])->name('perfil.user.create');
    Route::post('/user/{userId}/profile', [UserProfileController::class, 'upsert'])->name('user.profiles.upsert');



    Route::resource('saldos', SaldoController::class);

    Route::post('/gastos-autorizacion/{gasto}', [GastosController::class, 'autorizate'])->name('gastos.validar');
    Route::get('/index-jefaturas', [GastosController::class, 'index_jefatura'])->name('gastos.index.jefatura');
    Route::get('/index-finalizados', [GastosController::class, 'index_finalizados'])->name('gastos.index.finalizados');
    //Route::get('/saldos/create', [SaldoController::class, 'create'])->name('saldos.create');
    //Route::post('/saldos', [SaldoController::class, 'store'])->name('saldos.store');
});
