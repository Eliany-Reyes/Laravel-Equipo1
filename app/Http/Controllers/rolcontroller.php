<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class RolController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/roles/ObtenerTodos');
        $roles = $response->json();

        if (!is_array($roles)) {
            $roles = json_decode($response->body(), true) ?? [];
        }

        if (isset($roles['data']) && is_array($roles['data'])) {
            $roles = $roles['data'];
        }

        $roles = array_map(function ($row) {
            if (is_array($row)) {
                if (isset($row['creado_por'])) {
                    $row['creados_por'] = $row['creado_por'];
                }
                return $row;
            }
            $decoded = json_decode($row, true);
            if (is_array($decoded) && isset($decoded['creado_por'])) {
                $decoded['creados_por'] = $decoded['creado_por'];
            }
            return is_array($decoded) ? $decoded : [];
        }, $roles);

        return view('personas.roles', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'nivel_acceso' => 'required|integer',
            'permisos' => 'nullable|string|max:255',
            'creados_por' => 'nullable|string|max:100',
            'activo' => 'required|in:0,1',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $payload = [
            'PV_NOMBRE_ROL' => $validated['nombre_rol'],
            'PV_DESCRIPCION' => $validated['descripcion'] ?? '',
            'PI_NIVEL_ACCESO' => $validated['nivel_acceso'],
            'PV_PERMISOS' => $validated['permisos'] ?? '',
            'PV_CREADO_POR' => $validated['creados_por'] ?? '',
            'PB_ACTIVO' => (int) $validated['activo'],
            'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        ];

        $response = Http::post('http://localhost:3000/roles/InsertarRol', $payload);


        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol registrado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el rol: ' . $response->body());
        }
    }

    public function update(Request $request, $cod_rol): RedirectResponse
    {
        $validated = $request->validate([
            'nombre_rol' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'nivel_acceso' => 'required|integer',
            'permisos' => 'nullable|string|max:255',
            'creados_por' => 'nullable|string|max:100',
            'activo' => 'required|in:0,1',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $payload = [
            'PI_COD_ROL' => (int) $cod_rol,
            'PV_NOMBRE_ROL' => $validated['nombre_rol'],
            'PV_DESCRIPCION' => $validated['descripcion'] ?? '',
            'PI_NIVEL_ACCESO' => $validated['nivel_acceso'],
            'PV_PERMISOS' => $validated['permisos'] ?? '',
            'PV_CREADO_POR' => $validated['creados_por'] ?? '',
            'PB_ACTIVO' => (int) $validated['activo'],
            'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        ];

        $response = Http::put("http://localhost:3000/roles/ActualizarRol", $payload);

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el rol: ' . $response->body());
        }
    }

    public function destroy($cod_rol): RedirectResponse
    {
        $response = Http::delete("http://localhost:3000/roles/Eliminar/{$cod_rol}");

        if ($response->successful()) {
            return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el rol: ' . $response->body());
        }
    }
}
