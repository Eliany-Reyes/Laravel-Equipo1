<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class UsuarioController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/usuarios/ObtenerTodos');
        $usuarios = $response->json();

        if (!is_array($usuarios)) {
            $usuarios = json_decode($response->body(), true) ?? [];
        }

        if (isset($usuarios['data']) && is_array($usuarios['data'])) {
            $usuarios = $usuarios['data'];
        }

        $usuarios = array_map(function ($row) {
            if (is_array($row)) return $row;
            $decoded = json_decode($row, true);
            return is_array($decoded) ? $decoded : [];
        }, $usuarios);

        return view('personas.usuarios', compact('usuarios'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona' => 'required|integer',
            'nombre_usuario' => 'required|string|max:50',
            'correo_electronico' => 'required|email|max:100',
            'contrasena_plana' => 'required|string|max:50',
            'id_rol' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $payload = [
            'PI_COD_PERSONA' => $validated['cod_persona'],
            'PV_NOMBRE_USUARIO' => $validated['nombre_usuario'],
            'PV_CORREO_ELECTRONICO' => $validated['correo_electronico'],
            'PV_CONTRASENA_PLANA' => $validated['contrasena_plana'],
            'PI_ID_ROL' => $validated['id_rol'],
            'PB_ESTADO' => $validated['estado'] ? 1 : 0,
        ];

        $response = Http::post('http://localhost:3000/usuarios/insertarusuario', $payload);

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario registrado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el usuario: ' . $response->body());
        }
    }

    public function update(Request $request, $cod_usuario): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona' => 'required|integer',
            'nombre_usuario' => 'required|string|max:50',
            'correo_electronico' => 'required|email|max:100',
            'contrasena_plana' => 'nullable|string|max:50',
            'id_rol' => 'required|integer',
            'estado' => 'required|boolean',
        ]);

        $payload = [
            'PI_COD_USUARIO' => $cod_usuario,
            'PI_COD_PERSONA' => $validated['cod_persona'],
            'PV_NOMBRE_USUARIO' => $validated['nombre_usuario'],
            'PV_CORREO_ELECTRONICO' => $validated['correo_electronico'],
            'PV_CONTRASENA_PLANA' => $validated['contrasena_plana'] ?? null,
            'PI_ID_ROL' => $validated['id_rol'],
            'PB_ESTADO' => $validated['estado'] ? 1 : 0,
        ];

        $response = Http::put('http://localhost:3000/usuarios/actualizarusuario', $payload);

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $response->body());
        }
    }

    public function destroy($cod_usuario): RedirectResponse
    {
        $response = Http::delete("http://localhost:3000/usuarios/Eliminar/{$cod_usuario}");

        if ($response->successful()) {
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $response->body());
        }
    }
}
