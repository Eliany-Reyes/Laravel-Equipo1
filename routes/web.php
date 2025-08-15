<?php

use Illuminate\Support\Facades\Route;

/*---------------------------- MODULO AUNTENTICAR --------------------------------- */
use App\Http\Controllers\InicioController;


/*---------------------------- MODULO PERSONAS --------------------------------- */
use App\Http\Controllers\personaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\clienteController;
use App\Http\Controllers\empleadoController;
use App\Http\Controllers\empleadoRolController;
use App\Http\Controllers\correoController;
use App\Http\Controllers\TelefonoController;
use App\Http\Controllers\direccionController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\backupController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\PantallasController;
use App\Http\Controllers\permisocontroller;
use App\Http\Controllers\VisitasController;
use App\Http\Controllers\ReportesController;

/* ------------------------------------------------------------------------------*/

/*---------------------------- MODULO MANTENIMIENTO --------------------------------- */
use App\Http\Controllers\MantenimientoController;

/*---------------------------- MODULO BOSQUES --------------------------------- */
use App\Http\Controllers\BosqueController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\AccesoController;
use App\Http\Controllers\FloraFaunaController;


/* ------------------------------------------------------------------------------*/

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

/*---------------------------- MÓDULO BOSQUES --------------------------------- */

// ESTA RUTA MUESTRA EL MENÚ PRINCIPAL DEL MÓDULO DE BOSQUES
Route::get('/bosques/menu', function () {
    return view('bosques.modulos_bosques'); 
})->name('bosques.menu');

// ESTA ES LA RUTA PARA LA PANTALLA PRINCIPAL DEL MÓDULO
Route::get('/bosques/pantalla', function () {
    return view('pantalla-bosques'); 
})->name('bosques.pantalla');

// RUTA PARA OBTENER Y MOSTRAR TODOS LOS BOSQUES
Route::get('/bosques', [BosqueController::class, 'getBosques'])->name('bosques.index');
// RUTA PARA ENVIAR DATOS Y CREAR UN NUEVO BOSQUE
Route::post('/bosques', [BosqueController::class, 'postBosque'])->name('bosques.store');
// RUTA PARA MOSTRAR EL FORMULARIO PARA CREAR UN BOSQUE
Route::get('/bosques/create', [BosqueController::class, 'create'])->name('bosques.create');
// RUTA PARA MOSTRAR EL FORMULARIO DE EDICIÓN DE UN BOSQUE ESPECÍFICO
Route::get('/bosques/{cod_bosque}/edit', [BosqueController::class, 'edit'])->name('bosques.edit');
// RUTA PARA ENVIAR LA ACTUALIZACIÓN DE DATOS DE UN BOSQUE
Route::put('/bosques/{cod_bosque}', [BosqueController::class, 'updateBosque'])->name('bosques.update');

/*---------------------------- MÓDULO ACTIVIDADES --------------------------------- */

// RUTA PARA LA PANTALLA PRINCIPAL DEL MÓDULO DE ACTIVIDADES
Route::get('/actividades/pantalla', function () {
    return view('pantalla-actividades'); 
})->name('actividades.pantalla');

// RUTA PARA MOSTRAR TODAS LAS ACTIVIDADES
Route::get('/actividades', [ActividadesController::class, 'index'])->name('actividades.index');
// RUTA PARA GUARDAR UNA NUEVA ACTIVIDAD
Route::post('/actividades', [ActividadesController::class, 'store'])->name('actividades.store');
// RUTA PARA MOSTRAR EL FORMULARIO PARA CREAR UNA ACTIVIDAD
Route::get('/actividades/create', [ActividadesController::class, 'create'])->name('actividades.create');
// RUTA PARA MOSTRAR EL FORMULARIO DE EDICIÓN DE UNA ACTIVIDAD
Route::get('/actividades/{cod_actividad}/edit', [ActividadesController::class, 'edit'])->name('actividades.edit');
// RUTA PARA ENVIAR LA ACTUALIZACIÓN DE UNA ACTIVIDAD
Route::put('/actividades/{cod_actividad}', [ActividadesController::class, 'updateActividad'])->name('actividades.update');
// RUTA PARA ELIMINAR UNA ACTIVIDAD
Route::delete('/actividades/{cod_actividad}', [ActividadesController::class, 'destroy'])->name('actividades.destroy');

/*---------------------------- MÓDULO ACCESO --------------------------------- */

// RUTA PARA LA PANTALLA PRINCIPAL DEL MÓDULO DE ACCESO
Route::get('/acceso/pantalla', function () {
    return view('pantalla-acceso'); // ESTA ES LA PANTALLA PRINCIPAL DE ACCESO
})->name('acceso.pantalla');

// RUTA PARA MOSTRAR TODOS LOS ACCESOS
Route::get('/acceso', [AccesoController::class, 'getAccesos'])->name('acceso.index');
// RUTA PARA GUARDAR UN NUEVO ACCESO
Route::post('/acceso', [AccesoController::class, 'store'])->name('acceso.store');
// RUTA PARA MOSTRAR EL FORMULARIO PARA CREAR UN ACCESO
Route::get('/acceso/create', [AccesoController::class, 'create'])->name('acceso.create');
// RUTA PARA MOSTRAR EL FORMULARIO DE EDICIÓN DE UN ACCESO
Route::get('/acceso/{cod_acceso}/edit', [AccesoController::class, 'editAcceso'])->name('acceso.edit');
// RUTA PARA ENVIAR LA ACTUALIZACIÓN DE UN ACCESO
Route::put('/acceso/{cod_acceso}', [AccesoController::class, 'updateAcceso'])->name('acceso.update');
// RUTA PARA ELIMINAR UN ACCESO
Route::delete('/acceso/{cod_acceso}', [AccesoController::class, 'destroyAcceso'])->name('acceso.destroy');

/*---------------------------- MÓDULO FLORA Y FAUNA --------------------------------- */

// OBTENGO TODOS LOS BOSQUES
Route::get('/bosques', [BosqueController::class, 'getBosques'])->name('bosques.index');
// OBTENGO LA FLORA Y FAUNA DE UN BOSQUE ESPECÍFICO
Route::get('/bosques/flora-fauna', [FloraFaunaController::class, 'GetFloraFauna'])->name('bosques.florafauna');





























//--------------------------------------------------------------------------------------------------------------//

// módulo visitas
Route::get('/visitas', [VisitasController::class, 'GetVisitas'])->name('visitas.index');
Route::post('/visitas/guardar', [VisitasController::class, 'StoreVisita'])->name('visitas.store');
Route::put('/visitas/{cod_visita}/actualizar', [VisitasController::class, 'UpdateVisita'])->name('visitas.update');
Route::delete('/visitas/{cod_visita}', [VisitasController::class, 'destroy'])->name('visitas.destroy');
// menú del módulo
Route::view('/visitas-inicio', 'visitas.inicio')->name('visitas.inicio');
// Módulo Visitas (menú)
Route::view('/visitas-inicio', 'visitas.inicio')->name('visitas.inicio');

//--------------------------------------------------------------------------------------------------------------//



// módulo backups (rutas corregidas y completas)
// módulo backups
Route::get('/backup', [BackupController::class, 'index'])->name('backups.index');
Route::post('/backup/guardar', [BackupController::class, 'store'])->name('backups.store');
Route::put('/backup/{cod_backup}/actualizar', [BackupController::class, 'update'])->name('backups.update');
Route::delete('/backup/{cod_backup}', [BackupController::class, 'destroy'])->name('backups.destroy');

// Home grande
Route::get('/home', fn () => view('home'))->name('home');
// Submenú de Personas
Route::get('/personas-inicio', fn () => view('personas.inicio'))
    ->name('personas.inicio');
    // Submenú de Personas
Route::view('/personas-inicio', 'personas.submenu')->name('personas.inicio');

//--------------------------------------------------------------------------------------------------------------//


//Clientes
Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
Route::post('/clientes/guardar', [ClienteController::class, 'store'])->name('clientes.store');
Route::put('/clientes/{cod_cliente}/actualizar', [ClienteController::class, 'update'])->name('clientes.update');
Route::delete('/clientes/{cod_cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

// --- Rutas del Módulo de Correos ---
// Listar todos los correos
Route::get('/correos', [CorreoController::class, 'GetCorreos'])->name('correos.index');

// Guardar un nuevo correo
Route::post('/correos/guardar', [CorreoController::class, 'StoreCorreo'])->name('correos.store');

// Actualizar un correo existente
Route::put('/correos/{cod_correos}/actualizar', [CorreoController::class, 'UpdateCorreo'])->name('correos.update');

//--------------------------------------------------------------------------------------------------------------//


// --- Rutas del Módulo de Direcciones ---
// Ruta para mostrar todas las direcciones (GET)
Route::get('/direcciones', [DireccionController::class, 'index'])->name('direcciones.index');
// Ruta para guardar una nueva dirección (POST)
Route::post('/direcciones/guardar', [DireccionController::class, 'store'])->name('direcciones.store');
// Ruta para actualizar una dirección (PUT)
Route::put('/direcciones/{cod_direcciones}/actualizar', [DireccionController::class, 'update'])->name('direcciones.update');
// Ruta para eliminar una dirección (DELETE)
Route::delete('/direcciones/{cod_direcciones}', [DireccionController::class, 'destroy'])->name('direcciones.destroy');

//--------------------------------------------------------------------------------------------------------------//

// --- Rutas del Módulo Empleado-Rol ---
// Ruta GET para mostrar el listado de asignaciones empleado-rol.
Route::get('/empleados_roles', [EmpleadoRolController::class, 'index'])->name('empleadorol.index');
// Ruta POST para almacenar una nueva asignación empleado-rol.
Route::post('/empleados_roles/guardar', [EmpleadoRolController::class, 'store'])->name('empleadorol.store');

// Ruta PUT para actualizar una asignación empleado-rol.
Route::put('/empleados_roles/{cod_empleado}/actualizar', [EmpleadoRolController::class, 'update'])->name('empleadorol.update');

// Ruta DELETE para eliminar una asignación empleado-rol.
Route::delete('/empleados_roles/{cod_empleado}', [EmpleadoRolController::class, 'destroy'])->name('empleadorol.destroy');


// Empleados
Route::get('/empleados', [EmpleadoController::class, 'index']);
Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
Route::post('/empleados/guardar', [EmpleadoController::class, 'store'])->name('empleados.store');
Route::put('/empleados/{cod_empleado}/actualizar', [EmpleadoController::class, 'update'])->name('empleados.update');
Route::delete('/empleados/{cod_empleado}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');


// --- Rutas del Módulo Logins ---
Route::get('/logins', [LoginController::class, 'index'])->name('logins.index');
Route::post('/logins/guardar', [LoginController::class, 'store'])->name('logins.store');
Route::delete('/logins/{cod_Login}', [LoginController::class, 'destroy'])->name('logins.destroy');

// Rutas para el módulo de Reportes
Route::get('/Reportes', [ReportesController::class, 'index'])->name('reportes.index');
Route::post('/Reportes', [ReportesController::class, 'store'])->name('reportes.store');
Route::put('/Reportes', [ReportesController::class, 'update'])->name('reportes.update');

Route::view('/reportes-inicio', 'reportes.inicio')->name('reportes.inicio');
// Módulo Reportes (menú)
Route::view('/reportes-inicio', 'reportes.inicio')->name('reportes.inicio');

// Rutas para permisos
Route::get('permisos', [PermisoController::class, 'index'])->name('permisos.index');
Route::post('permisos', [PermisoController::class, 'store'])->name('permisos.store');
Route::put('permisos/{cod_permisos}', [PermisoController::class, 'update'])->name('permisos.update');
Route::delete('permisos/{cod_permisos}', [PermisoController::class, 'destroy'])->name('permisos.destroy');

// Rutas de pantallas
Route::get('/pantallas', [PantallasController::class, 'index'])->name('pantallas.index');
Route::post('/pantallas', [PantallasController::class, 'store'])->name('pantallas.store');
Route::put('/pantallas/{id}', [PantallasController::class, 'update'])->name('pantallas.update');
Route::delete('/pantallas/{id}', [PantallasController::class, 'destroy'])->name('pantallas.destroy');

// Rutas para roles
Route::get('/roles', [RolController::class, 'index'])->name('roles.index');
Route::post('/roles', [RolController::class, 'store'])->name('roles.store');
Route::put('/roles/{cod_rol}/actualizar', [RolController::class, 'update'])->name('roles.update');
Route::delete('/roles/{cod_rol}', [RolController::class, 'destroy'])->name('roles.destroy');

//rutas para usuarios
Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::put('usuarios/{id}/actualizar', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

//Rutas de Telefonos
    Route::get('/telefonos', [TelefonoController::class, 'index'])->name('telefonos.index');
    Route::post('/telefonos/store', [TelefonoController::class, 'store'])->name('telefonos.store');
    Route::put('/telefonos/{cod_telefono}/actualizar', [TelefonoController::class, 'update'])->name('telefonos.update');
    Route::delete('/telefonos/{cod_telefono}/destroy', [TelefonoController::class, 'destroy'])->name('telefonos.destroy');