<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class PermisoController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/permisos/ObtenerTodos');
        $permisos = $response->json();

        if (!is_array($permisos)) {
            $permisos = json_decode($response->body(), true) ?? [];
        }

        if (isset($permisos['data']) && is_array($permisos['data'])) {
            $permisos = $permisos['data'];
        }

        $permisos = array_map(function ($row) {
            if (is_array($row)) return $row;
            $decoded = json_decode($row, true);
            return is_array($decoded) ? $decoded : [];
        }, $permisos);

        return view('personas.permisos', compact('permisos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_rol' => 'required|integer',
            'id_pantalla' => 'required|integer',
            'puede_ver' => 'required|boolean',
            'puede_crear' => 'required|boolean',
            'puede_editar' => 'required|boolean',
            'puede_eliminar' => 'required|boolean',
            'puede_exportar' => 'required|boolean',
            'restriccion_horario' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
            // 'fecha_creacion' => 'nullable|date',
        ]);

        $payload = [
            'PI_ID_ROL' => $validated['id_rol'],
            'PI_ID_PANTALLA' => $validated['id_pantalla'],
            'PB_PUEDE_VER' => $validated['puede_ver'] ? 1 : 0,
            'PB_PUEDE_CREAR' => $validated['puede_crear'] ? 1 : 0,
            'PB_PUEDE_EDITAR' => $validated['puede_editar'] ? 1 : 0,
            'PB_PUEDE_ELIMINAR' => $validated['puede_eliminar'] ? 1 : 0,
            'PB_PUEDE_EXPORTAR' => $validated['puede_exportar'] ? 1 : 0,
            'PV_RESTRICCION_HORARIO' => $validated['restriccion_horario'] ?? '',
            'PB_ACTIVO' => $validated['activo'] ? 1 : 0,
            // 'PD_FECHA_CREACION' => $validated['fecha_creacion'] ?? null,
        ];

        $response = Http::post('http://localhost:3000/permisos/Insertar', $payload);

        if ($response->successful()) {
            return redirect()->route('permisos.index')->with('success', 'Permiso registrado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el permiso: ' . $response->body());
        }
    }

    public function update(Request $request, $cod_permisos): RedirectResponse
    {
        $validated = $request->validate([
            'id_rol' => 'required|integer',
            'id_pantalla' => 'required|integer',
            'puede_ver' => 'required|boolean',
            'puede_crear' => 'required|boolean',
            'puede_editar' => 'required|boolean',
            'puede_eliminar' => 'required|boolean',
            'puede_exportar' => 'required|boolean',
            'restriccion_horario' => 'nullable|string|max:255',
            'activo' => 'required|boolean',
            'fecha_creacion' => 'nullable|date',
        ]);

        $payload = [
            'PI_COD_PERMISOS' => $cod_permisos,
            'PI_ID_ROL' => $validated['id_rol'],
            'PI_ID_PANTALLA' => $validated['id_pantalla'],
            'PB_PUEDE_VER' => $validated['puede_ver'] ? 1 : 0,
            'PB_PUEDE_CREAR' => $validated['puede_crear'] ? 1 : 0,
            'PB_PUEDE_EDITAR' => $validated['puede_editar'] ? 1 : 0,
            'PB_PUEDE_ELIMINAR' => $validated['puede_eliminar'] ? 1 : 0,
            'PB_PUEDE_EXPORTAR' => $validated['puede_exportar'] ? 1 : 0,
            'PV_RESTRICCION_HORARIO' => $validated['restriccion_horario'] ?? '',
            'PB_ACTIVO' => $validated['activo'] ? 1 : 0,
            'PD_FECHA_CREACION' => $validated['fecha_creacion'] ?? null,
        ];

        $response = Http::put('http://localhost:3000/permisos/Actualizar', $payload);

        if ($response->successful()) {
            return redirect()->route('permisos.index')->with('success', 'Permiso actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el permiso: ' . $response->body());
        }
    }

    public function destroy($cod_permisos): RedirectResponse
    {
        $response = Http::delete("http://localhost:3000/Eliminar/{$cod_permisos}");

        if ($response->successful()) {
            return redirect()->route('permisos.index')->with('success', 'Permiso eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el permiso: ' . $response->body());
        }
    }
}
