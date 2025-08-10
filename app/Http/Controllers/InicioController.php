<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\User;

class InicioController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Procesa el intento de inicio de sesión.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo_electronico' => 'required|email',
            'contrasena' => 'required',
        ]);

        // Encuentra al usuario por el correo electrónico
        $user = User::where('correo_electronico', $credentials['correo_electronico'])->first();

        // Si el usuario existe y las contraseñas coinciden, inicia sesión
        if ($user && Hash::check($credentials['contrasena'], $user->contrasena)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'correo_electronico' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('correo_electronico');
    }

    /**
     * Muestra la página principal
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Cierra la sesión del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
 * Muestra el formulario de registro.
 *
 * @return \Illuminate\View\View
 */
public function showRegistrationForm()
{
    return view('registro');
}

/**
 * Procesa el formulario de registro.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function register(Request $request)
{
    // Lógica de validación
    $request->validate([
        'nombre_usuario' => 'required|string|max:255',
        'correo_electronico' => 'required|email|unique:Usuarios,correo_electronico',
        'contrasena' => 'required|string|min:3|confirmed',
    ]);

    // Crear el nuevo usuario 
    $user = User::create([
        'nombre_usuario' => $request->nombre_usuario,
        'correo_electronico' => $request->correo_electronico,
        'contrasena' => Hash::make($request->contrasena),
        'contrasena_plana' => $request->contrasena,
        'id_rol' => 1,
        'estado' => 'Inactivo',
        'fecha_registro' => now(),
        'ultimo_acceso' => now()
    ]);

    // Redirigir a una nueva página para asignar el cod_persona
    return redirect()->route('assign.cod_persona', ['user' => $user->cod_usuario]);
}


/**
 * Muestra el formulario para asignar el código de persona.
 * Se accede después de que un usuario se ha registrado.
 * @return \Illuminate\View\View
 */
public function showAssignForm(User $user)
{
    // Carga la vista 'asignar_cod_persona' y le pasa el objeto de usuario
    return view('asignar_cod_persona', compact('user'));
}

/**
 * Procesa la asignación del código de persona y activa el usuario.
 * @param  \Illuminate\Http\Request  $request
 * @param  \App\Models\User  $user
 * @return \Illuminate\Http\RedirectResponse
 */
public function updateCodPersona(Request $request, User $user)
{
    // Valida que el cod_persona sea un número y no esté en uso
    $request->validate([
        'cod_persona' => 'required|integer|unique:Usuarios,cod_persona',
    ]);

    // Asigna el cod_persona y cambia el estado del usuario a 'Activo'
    $user->update([
        'cod_persona' => $request->cod_persona,
        'estado' => 'Activo'
    ]);

    // Inicia sesión al usuario recién activado
    Auth::login($user);

    return redirect()->route('home')->with('success', 'Código de persona asignado y usuario activado.');
}

}