<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class TelefonoController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost:3000/telefonos/obtenerTelefono');

        $telefonos = [];

        if ($response->successful()) {
            $json = $response->json();

            // Si hay 'data', lo usamos
            $raw = $json['data'] ?? $json;

            // Convertimos a array y llaves en minúsculas
            $telefonos = array_map(function($item) {
                return array_change_key_case((array) $item, CASE_LOWER);
            }, $raw);
        }

        return view('personas.telefonos', compact('telefonos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona' => 'required|integer',
            'telefono_personal' => 'nullable|string|max:20',
            'segundo_telefono' => 'nullable|string|max:20',
            'telefono_trabajo' => 'nullable|string|max:20',
            'telefono_fijo' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $payload = [
            'PI_COD_PERSONA' => $validated['cod_persona'],
            'PV_TELEFONO_PERSONAL' => $validated['telefono_personal'] ?? '',
            'PV_SEGUNDO_TELEFONO' => $validated['segundo_telefono'] ?? '',
            'PV_TELEFONO_TRABAJO' => $validated['telefono_trabajo'] ?? '',
            'PV_TELEFONO_FIJO' => $validated['telefono_fijo'] ?? '',
            'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        ];

        $response = Http::post('http://localhost:3000/telefonos/InsertarTelefono', $payload);

        if ($response->successful()) {
            return redirect()->route('telefonos.index')->with('success', 'Teléfono registrado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al registrar el teléfono: ' . $response->body());
        }
    }

    public function update(Request $request, $cod_telefono): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona' => 'required|integer',
            'telefono_personal' => 'nullable|string|max:20',
            'segundo_telefono' => 'nullable|string|max:20',
            'telefono_trabajo' => 'nullable|string|max:20',
            'telefono_fijo' => 'nullable|string|max:20',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $payload = [
            'PI_COD_TELEFONO' => $cod_telefono,
            'PI_COD_PERSONA' => $validated['cod_persona'],
            'PV_TELEFONO_PERSONAL' => $validated['telefono_personal'] ?? '',
            'PV_SEGUNDO_TELEFONO' => $validated['segundo_telefono'] ?? '',
            'PV_TELEFONO_TRABAJO' => $validated['telefono_trabajo'] ?? '',
            'PV_TELEFONO_FIJO' => $validated['telefono_fijo'] ?? '',
            'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        ];

        $response = Http::put('http://localhost:3000/telefonos/actualizarTelefono', $payload);

        if ($response->successful()) {
            return redirect()->route('telefonos.index')->with('success', 'Teléfono actualizado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el teléfono: ' . $response->body());
        }
    }

    public function destroy($cod_telefono): RedirectResponse
    {
        $response = Http::delete("http://localhost:3000/telefonos/Eliminar/{$cod_telefono}");

        if ($response->successful()) {
            return redirect()->route('telefonos.index')->with('success', 'Teléfono eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'Error al eliminar el teléfono: ' . $response->body());
        }
    }
}
