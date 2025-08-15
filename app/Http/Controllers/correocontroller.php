<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class CorreoController extends Controller
{
    private string $api = 'http://localhost:3000';

    // GET /correos
    public function GetCorreos()
    {
        $response = Http::get("{$this->api}/correos/obtenertodos");
        $correos = $response->json();

        if (!is_array($correos)) {
            $correos = json_decode($response->body(), true) ?? [];
        }
        if (isset($correos['data']) && is_array($correos['data'])) {
            $correos = $correos['data'];
        }

        return view('personas.correos', compact('correos'));
    }

    // POST /correos/guardar
    public function StoreCorreo(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'          => 'required|integer|min:1',
            'correo_personal'      => 'nullable|email|max:50',
            'correo_empleado'      => 'nullable|email|max:50',
            'correo_secundario'    => 'nullable|email|max:50',
            'correo_institucional' => 'nullable|email|max:50',
            'observaciones'        => 'nullable|string|max:255',
        ]);

        if (
            empty($validated['correo_personal']) &&
            empty($validated['correo_empleado']) &&
            empty($validated['correo_secundario']) &&
            empty($validated['correo_institucional'])
        ) {
            return back()->with('error', 'Debe ingresar al menos un correo.')->withInput();
        }

        $payload = [
            'cod_persona'          => $validated['cod_persona'],
            'correo_personal'      => $validated['correo_personal'] ?? null,
            'correo_empleado'      => $validated['correo_empleado'] ?? null,
            'correo_secundario'    => $validated['correo_secundario'] ?? null,
            'correo_institucional' => $validated['correo_institucional'] ?? null,
            'observaciones'        => $validated['observaciones'] ?? null,
        ];

        $response = Http::post("{$this->api}/correos/insertarcorreo", $payload);

        if ($response->failed()) {
            return back()->with('error', 'Error HTTP al registrar: '.$response->body())->withInput();
        }

        return redirect()->route('correos.index')->with('success', 'Correo registrado correctamente.');
    }

    // PUT /correos/{cod_correos}/actualizar
    public function UpdateCorreo(Request $request, $cod_correos): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'          => 'required|integer|min:1',
            'correo_personal'      => 'nullable|email|max:50',
            'correo_empleado'      => 'nullable|email|max:50',
            'correo_secundario'    => 'nullable|email|max:50',
            'correo_institucional' => 'nullable|email|max:50',
            'observaciones'        => 'nullable|string|max:255',
        ]);

        if (
            empty($validated['correo_personal']) &&
            empty($validated['correo_empleado']) &&
            empty($validated['correo_secundario']) &&
            empty($validated['correo_institucional'])
        ) {
            return back()->with('error', 'Debe ingresar al menos un correo.')->withInput();
        }

        // Mandamos el ID en el body
        $payload = [
            'cod_correos'          => (int)$cod_correos,
            'cod_persona'          => $validated['cod_persona'],
            'correo_personal'      => $validated['correo_personal'] ?? null,
            'correo_empleado'      => $validated['correo_empleado'] ?? null,
            'correo_secundario'    => $validated['correo_secundario'] ?? null,
            'correo_institucional' => $validated['correo_institucional'] ?? null,
            'observaciones'        => $validated['observaciones'] ?? null,
        ];

        $response = Http::put("{$this->api}/correos/actualizarcorreo", $payload);

        if ($response->failed()) {
            return back()->with('error', 'Error HTTP al actualizar: '.$response->body())->withInput();
        }

        return redirect()->route('correos.index')->with('success', 'Correo actualizado correctamente.');
    }
}
