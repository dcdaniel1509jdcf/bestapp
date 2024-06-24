<?php

use App\Http\Controllers\Admin\AgenciasController;
use App\Http\Controllers\Admin\PermissionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Formularios\DepositosController;
use App\Http\Controllers\Formularios\ReporteController;
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
    Route::resource('permissions', PermissionController::class);
    Route::resource('depositos', DepositosController::class);
    Route::resource('agencias', AgenciasController::class);
    Route::resource('agencias', AgenciasController::class);

    Route::resource('reportes', ReporteController::class);
    Route::post('depositos-download', [DepositosController::class, 'download'])->name('depositos.download');
    Route::patch('depositos-autorizacion/{deposito}', [DepositosController::class, 'autorizate'])->name('depositos.autorizacion');

    // Route::resource('productos', ProductController::class);
});
