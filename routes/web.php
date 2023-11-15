<?php

use Illuminate\Support\Facades\Route;
//controladores

use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VacacionesController;
use App\Http\Controllers\DescansosMedicosController;
use App\Http\Controllers\LicenciasController;
use App\Http\Controllers\AislamientosController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SuspensionesController;
use App\Http\Controllers\MarcadoresController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::group(['middleware'=>['auth']],function () {
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);

    Route::get('/general', [GeneralController::class, 'index'])->name('general');
    Route::post('/general', [GeneralController::class, 'consultar'])->name('general.consultar');

    Route::get('/vacaciones',[VacacionesController::class, 'index'])->name('vacaciones');
    Route::get('tablavacaciones',[VacacionesController::class,'tablavacaciones'])->name('tabla.vacaciones');

    Route::get('/licencias',[LicenciasController::class, 'index'])->name('licencias');
    Route::get('tablalicencias',[LicenciasController::class,'tablalicencias'])->name('tabla.licencias');

    Route::get('/descansosmedicos',[DescansosMedicosController::class, 'index'])->name('descansosmedicos');
    Route::get('tabladescansosmedicos',[DescansosMedicosController::class,'tabladescansosmedicos'])->name('tabla.descansosmedicos');

    Route::get('/aislamientos',[AislamientosController::class, 'index'])->name('aislamientos');
    Route::get('tablaaislamientos',[AislamientosController::class,'tablaaislamientos'])->name('tabla.aislamientos');

    Route::get('/suspensiones',[SuspensionesController::class, 'index'])->name('suspensiones');
    Route::get('tablasuspensiones',[SuspensionesController::class,'tablasuspensiones'])->name('tabla.suspensiones');

    Route::get('detalle/{cod}/crear',[RegistroController::class, 'registrar'])->name('registro.edit');
    Route::post('store', [RegistroController::class, 'store'])->name('store');
    Route::get('detalle/conceptos', [RegistroController::class, 'conceptos'])->name('conceptos.todos');

    Route::post('vacaciones/export/', [VacacionesController::class, 'export'])->name('vacaciones.export');
    Route::post('suspensiones/export/', [SuspensionesController::class, 'export'])->name('suspensiones.export');
    Route::post('descansosmedicos/export/', [DescansosMedicosController::class, 'export'])->name('descansosmedicos.export');
    Route::post('licencias/export/', [LicenciasController::class, 'export'])->name('licencias.export');
    Route::post('aislamientos/export/', [AislamientosController::class, 'export'])->name('aislamientos.export');

    // Rutas para el apartado consultas
    Route::get('/consultas', [ConsultasController::class,'index'])->name('consultas');
    Route::post('/consultas', [ConsultasController::class,'total_dias'])->name('consulta.totaldias');
    Route::post('/consulta/export/', [ConsultasController::class, 'export'])->name('consultas.export');

    // En observación, por las validaciones al cargar de forma masiva
    Route::get('cargamasiva', [RegistroController::class, 'cargamasiva'])->name('cargamasiva');
    Route::post('import', [RegistroController::class, 'import'])->name('import');
    Route::post('desactivar',[RegistroController::class, 'desactivar'])->name('desactivar.registro');
    Route::get('registro/{id}/editar', [RegistroController::class, 'edit'])->name('registro.editar');
    Route::get('editar/{id}', [RegistroController::class, 'update'])->name('update');
    Route::get('manual/{file}', [RegistroController::class, 'descargamanual'])->name('descargar.manual');
    Route::get('export/all', [RegistroController::class,'exportall'])->name('exportar.todos');

    // Rutas para la gestion de marcadores
    Route::get('/marcadores',[MarcadoresController::class, 'index'])->name('marcadores');
    Route::post('/marcadores/store', [MarcadoresController::class, 'store'])->name('marcadores.store');
    Route::get('/marcadores/change/{id}/status', [MarcadoresController::class, 'change_status'])->name('marcadores.change.status');
    Route::post('/marcadores/update', [MarcadoresController::class, 'update'])->name('marcadores.update');
    Route::post('/marcadores/{id}/delete', [MarcadoresController::class, 'delete'])->name('marcadores.delete');
    Route::get('/marcadores/{id}/attendance', [MarcadoresController::class, 'get_attendance'])->name('marcadores.attendance');

    // Descargar marcaciones
    Route::post('/marcaciones/downloads', [MarcadoresController::class,'downloads'])->name('marcaciones.downloads');
});
