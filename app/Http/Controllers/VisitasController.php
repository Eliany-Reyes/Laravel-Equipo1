<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class VisitasController extends Controller
{
 public function GetVisitas()
{
    $response = Http::get('http://localhost:3000/visitas');

    // 1) Base
    $visitas = $response->json();

    // 2) Si vino algo no-array, intenta decodificar; si no, usa []
    if (!is_array($visitas)) {
        $visitas = json_decode($response->body(), true) ?? [];
    }

    // 3) Si tu API envuelve en { data: [...] }
    if (isset($visitas['data']) && is_array($visitas['data'])) {
        $visitas = $visitas['data'];
    }

    // 4) Normaliza cada fila: si viene string, decodifica a array
    $visitas = array_map(function ($row) {
        if (is_array($row)) return $row;
        $decoded = json_decode($row, true);
        return is_array($decoded) ? $decoded : [];
    }, $visitas);

    return view('visitas.visitas', compact('visitas'));
}



    /**
     * Registrar nueva visita (POST)
     */public function StoreVisita(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'cod_persona' => 'required|integer',
        'hora_salida' => 'nullable|date',
        'motivo_visita' => 'required|string|max:255',
        'observaciones' => 'nullable|string',
        'cantidad_adultos' => 'required|integer|min:0',
        'cantidad_ninos' => 'required|integer|min:0',
        'precio_entrada_adulto' => 'nullable|numeric',
        'precio_entrada_nino' => 'nullable|numeric',
        'cod_bosque' => 'required|integer',
        'cod_acceso' => 'required|integer',
    ]);

    // Formatear hora salida
    if (!empty($validated['hora_salida'])) {
        $validated['hora_salida'] = date('Y-m-d H:i:s', strtotime($validated['hora_salida']));
    }

    // Mapear a los nombres que espera la API Node
    $payload = [
        'PI_COD_PERSONA' => $validated['cod_persona'],
        'PV_HORA_SALIDA' => $validated['hora_salida'] ?? null,
        'PV_MOTIVO_VISITA' => $validated['motivo_visita'],
        'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        'PI_CANTIDAD_ADULTOS' => $validated['cantidad_adultos'],
        'PI_CANTIDAD_NINOS' => $validated['cantidad_ninos'],
        'PD_PRECIO_ENTRADA_ADULTO' => $validated['precio_entrada_adulto'] ?? 0,
        'PD_PRECIO_ENTRADA_NINO' => $validated['precio_entrada_nino'] ?? 0,
        'PI_COD_BOSQUE' => $validated['cod_bosque'],
        'PI_COD_ACCESO' => $validated['cod_acceso'],
    ];

    // Enviar a la API Node
    $response = Http::post('http://localhost:3000/visitas/insertar', $payload);

    if ($response->successful()) {
        return redirect()
            ->route('visitas.index')
            ->with('success', 'Visita registrada correctamente.');
    } else {
        return redirect()
            ->back()
            ->with('error', 'Error al registrar la visita: ' . $response->body());
    }
}
public function UpdateVisita(Request $request, $cod_visita): RedirectResponse
{
    // Validar datos recibidos del formulario
    $validated = $request->validate([
        'hora_salida' => 'nullable|date',
        'motivo_visita' => 'required|string|max:255',
        'observaciones' => 'nullable|string',
        'cantidad_adultos' => 'required|integer|min:0',
        'cantidad_ninos' => 'required|integer|min:0',
        'precio_entrada_adulto' => 'nullable|numeric',
        'precio_entrada_nino' => 'nullable|numeric',
    ]);

    // Formatear hora salida
    if (!empty($validated['hora_salida'])) {
        $validated['hora_salida'] = date('Y-m-d H:i:s', strtotime($validated['hora_salida']));
    }

    // Mapear a nombres que espera la API Node
    $payload = [
        'PV_HORA_SALIDA' => $validated['hora_salida'] ?? null,
        'PV_MOTIVO_VISITA' => $validated['motivo_visita'],
        'PV_OBSERVACIONES' => $validated['observaciones'] ?? '',
        'PI_CANTIDAD_ADULTOS' => $validated['cantidad_adultos'],
        'PI_CANTIDAD_NINOS' => $validated['cantidad_ninos'],
        'PD_PRECIO_ENTRADA_ADULTO' => $validated['precio_entrada_adulto'] ?? 0,
        'PD_PRECIO_ENTRADA_NINO' => $validated['precio_entrada_nino'] ?? 0,
    ];

    // Llamar API Node
    $response = Http::put("http://localhost:3000/visitas/{$cod_visita}", $payload);

    if ($response->successful()) {
        return redirect()
            ->route('visitas.index')
            ->with('success', 'Visita actualizada correctamente.');
    } else {
        return redirect()
            ->back()
            ->with('error', 'Error al actualizar la visita: ' . $response->body());
    }
}
public function destroy($cod_visita)
{
    $response = Http::delete("http://localhost:3000/visitas/{$cod_visita}");

    if ($response->successful()) {
        return redirect()->route('visitas.index')->with('success', 'Visita eliminada correctamente');
    } else {
        return redirect()->route('visitas.index')->with('error', 'Error al eliminar la visita: ' . $response->body());
    }
}

}
