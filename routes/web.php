<?php

use Illuminate\Support\Facades\Route;

/*---------------------------- MODULO AUNTENTICAR --------------------------------- */
use App\Http\Controllers\InicioController;


/*---------------------------- MODULO PERSONAS --------------------------------- */
use App\Http\Controllers\personaController;
use App\Http\Controllers\usuarioController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\empleadoController;
use App\Http\Controllers\empleadoRolController;
use App\Http\Controllers\correoController;
use App\Http\Controllers\telefonoController;
use App\Http\Controllers\direccionController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\backupController;
use App\Http\Controllers\rolController;
use App\Http\Controllers\pantallaController;
use App\Http\Controllers\permisoController;

/* ------------------------------------------------------------------------------*/

/*---------------------------- MODULO MANTENIMIENTO --------------------------------- */
use App\Http\Controllers\MantenimientoController;

/*
/*---------------------------- MODULO EVENTOS --------------------------------- */
use App\Http\Controllers\eventoController;
use App\Http\Controllers\reservaController;
use App\Http\Controllers\FacturaController;
/*

|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí puedes registrar rutas web para tu aplicación. Estas
| rutas son cargadas por el RouteServiceProvider dentro de un grupo que
| contiene el "web" middleware group. ¡Crea algo grandioso!
|
*/

// La ruta raíz ahora lleva al formulario de inicio de sesión
//Route::get('/', [AunteticarController::class, 'mostrarInicioFormulario'])->name('inicio');

/*---------------------------- MODULO PERSONAS --------------------------------- */
Route::get('/personas', [personaController::class, 'GetPersonas']);
Route::get('/usuarios', [usuarioController::class, 'GetUsuario']);
Route::get('/clientes', [clienteController::class, 'GetClientes']);
Route::get('/empleados', [EmpleadoController::class, 'GetEmpleados']);
Route::get('/empleados_roles', [EmpleadoRolController::class, 'GetEmpleadosRoles']);
Route::get('/correos', [CorreoController::class, 'GetCorreos']);
Route::get('/telefonos', [TelefonoController::class, 'GetTelefonos']);
Route::get('/direcciones', [DireccionController::class, 'GetDirecciones']);
Route::get('/login', [LoginController::class, 'GetLogins']);
Route::get('/backup', [BackupController::class, 'GetBackups']);
Route::get('/roles', [RolController::class, 'GetRoles']);
Route::get('/pantallas', [PantallaController::class, 'GetPantallas']);
Route::get('/permisos', [PermisoController::class, 'GetPermisos']);

/*---------------------------- MODULO MANTENIMIENTO --------------------------------- */

// Ruta para la pantalla de inicio del módulo de mantenimiento
Route::get('/mantenimiento-inicio', [MantenimientoController::class, 'indexPantalla'])->name('mantenimientos.index_pantalla');

// Ruta para la vista principal, que ahora usa GetMantenimientos()
Route::get('mantenimientos', [MantenimientoController::class, 'GetMantenimientos'])->name('mantenimientos.index');

// Ruta para mostrar el formulario de creación
Route::get('mantenimientos/create', [MantenimientoController::class, 'create'])->name('mantenimientos.create');

// Ruta para guardar un nuevo mantenimiento
Route::post('mantenimientos', [MantenimientoController::class, 'store'])->name('mantenimientos.store');

// Ruta para mostrar el formulario de edición
Route::get('mantenimientos/{id}/edit', [MantenimientoController::class, 'edit'])->name('mantenimientos.edit');

// Ruta para actualizar un mantenimiento
Route::put('mantenimientos/{id}', [MantenimientoController::class, 'update'])->name('mantenimientos.update');

// Ruta para eliminar un mantenimiento
Route::delete('mantenimientos/{id}', [MantenimientoController::class, 'destroy'])->name('mantenimientos.destroy');

/*---------------------------- MODULO AUTENTICACIÓN --------------------------------- */

// Rutas para la autenticación usando InicioController
Route::get('/inicio', [InicioController::class, 'showLoginForm'])->name('login');
Route::post('/inicio', [InicioController::class, 'login']);

// Rutas para el registro de usuarios
Route::get('/register', [InicioController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [InicioController::class, 'register']);

// Ruta de inicio (dashboard) a la que se redirigirá después del login
Route::get('/home', [InicioController::class, 'index'])->name('home')->middleware('auth');

// Ruta para el logout
Route::post('/logout', [InicioController::class, 'logout'])->name('logout');


// Ruta que muestra el formulario de asignación (después del registro)
Route::get('/assign/{user}', [InicioController::class, 'showAssignForm'])->name('assign.cod_persona');

// Ruta que procesa el formulario de asignación y actualiza el usuario
Route::put('/update-cod-persona/{user}', [InicioController::class, 'updateCodPersona'])->name('update.cod_persona');


/*---------------------------- MODULO EVENTOS --------------------------------- */
Route::get('/eventos', [EventoController::class, 'GetEventos'])->name('eventos.index');


//POST
Route::post('/eventos', [EventoController::class, 'postEventos'])->name('eventos.actualizar');
// Ruta para mostrar el formulario de creación. Esta es la que faltaba.
Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');

//PUT

// Nueva ruta para mostrar el formulario de edición de un evento
Route::get('/eventos/{cod_evento}/edit', [EventoController::class, 'edit'])->name('eventos.edit');

// Ruta para procesar la actualización del evento con el método PUT
Route::put('/eventos/{cod_evento}', [EventoController::class, 'updateEventos'])->name('eventos.update');

//ruta delete
Route::delete('/eventos/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');


//FACTURAS
Route::get('/facturas', [FacturaController::class, 'GetFacturas'])->name('factura.index');

//POST
Route::post('/facturas', [FacturaController::class, 'postFacturas'])->name('factura.actualizar');
// Ruta para mostrar el formulario de creación. Esta es la que faltaba.
Route::get('/facturas/create', [FacturaController::class, 'create'])->name('factura.create');

//PUT

Route::get('/facturas/{cod_factura}/edit', [FacturaController::class, 'edit'])->name('factura.edit');

// Ruta para procesar la actualización del evento con el método PUT
Route::put('/facturas/{cod_factura}', [FacturaController::class, 'updateFactura'])->name('factura.update');

//ruta delete
Route::delete('/facturas/{id}', [FacturaController::class, 'destroy'])->name('factura.destroy');


                                    //RESERVAS
Route::get('/reservas', [ReservaController::class, 'GetReservas'])->name('reserva.index');

//POST
Route::post('/reservas', [ReservaController::class, 'postReserva'])->name('reserva.actualizar');
// Ruta para mostrar el formulario de creación. Esta es la que faltaba.
Route::get('/reservas/create', [ReservaController::class, 'create'])->name('reserva.create');

//PUT

Route::get('/reservas/{cod_reserva}/edit', [ReservaController::class, 'edit'])->name('reserva.edit');

// Ruta para procesar la actualización del evento con el método PUT
Route::put('/reservas/{cod_reserva}', [ReservaController::class, 'updateReserva'])->name('reserva.update');

//ruta delete
Route::delete('/reservas/{id}', [ReservaController::class, 'destroy'])->name('reserva.destroy');


