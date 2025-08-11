<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class DireccionController extends Controller
{
    // URL base de la API
    private string $api = 'http://localhost:3000';

    /**
     * Muestra la lista de direcciones.
     * Corresponde a la ruta GET /direcciones
     */
    public function index()
    {
        $response = Http::get("{$this->api}/direccion/obtenertodos");
        $direcciones = $response->json();
        
        // Normalización de la respuesta de la API
        if (!is_array($direcciones)) {
            $direcciones = json_decode($response->body(), true) ?? [];
        }
        if (isset($direcciones['data']) && is_array($direcciones['data'])) {
            $direcciones = $direcciones['data'];
        }

        return view('personas.direcciones', compact('direcciones'));
    }

    /**
     * Almacena una nueva dirección.
     * Corresponde a la ruta POST /direcciones
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'       => 'required|integer',
            'direccion_hogar'   => 'nullable|string',
            'ciudad'            => 'nullable|string|max:40',
            'departamento'      => 'nullable|string|max:40',
            'colonia'           => 'nullable|string|max:40',
            'codigo_postal'     => 'nullable|integer',
            'direccion_trabajo' => 'nullable|string',
        ]);

        $payload = [
            'p_cod_persona'       => (int)$validated['cod_persona'],
            'p_direccion_hogar'   => $validated['direccion_hogar'] ?? null,
            'p_ciudad'            => $validated['ciudad'] ?? null,
            'p_departamento'      => $validated['departamento'] ?? null,
            'p_colonia'           => $validated['colonia'] ?? null,
            'p_codigo_postal'     => $validated['codigo_postal'] ?? null,
            'p_direccion_trabajo' => $validated['direccion_trabajo'] ?? null,
        ];
        
        $response = Http::post("{$this->api}/direccion/insertardireccion", $payload);

        $body = $response->json();
        if (!is_array($body)) $body = json_decode($response->body(), true);
        
        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al registrar: '.$response->body())->withInput();
        }
        $msg = strtolower($body['mensaje'] ?? '');
        if ($msg && !str_contains($msg, 'éxito') && !str_contains($msg, 'exito') && !str_contains($msg, 'success')) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        return redirect()->route('direcciones.index')->with('success', 'Dirección registrada correctamente.');
    }

    /**
     * Actualiza una dirección existente.
     * Corresponde a la ruta PUT /direcciones/{cod_direcciones}
     */
    public function update(Request $request, $cod_direcciones): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'       => 'required|integer',
            'direccion_hogar'   => 'nullable|string',
            'ciudad'            => 'nullable|string|max:40',
            'departamento'      => 'nullable|string|max:40',
            'colonia'           => 'nullable|string|max:40',
            'codigo_postal'     => 'nullable|integer',
            'direccion_trabajo' => 'nullable|string',
        ]);

        $payload = [
            'p_cod_direcciones'   => (int)$cod_direcciones,
            'p_cod_persona'       => (int)$validated['cod_persona'],
            'p_direccion_hogar'   => $validated['direccion_hogar'] ?? null,
            'p_ciudad'            => $validated['ciudad'] ?? null,
            'p_departamento'      => $validated['departamento'] ?? null,
            'p_colonia'           => $validated['colonia'] ?? null,
            'p_codigo_postal'     => $validated['codigo_postal'] ?? null,
            'p_direccion_trabajo' => $validated['direccion_trabajo'] ?? null,
        ];
        
        $response = Http::put("{$this->api}/direccion/actualizardireccion", $payload);

        $body = $response->json();
        if (!is_array($body)) $body = json_decode($response->body(), true);
        
        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al actualizar: '.$response->body())->withInput();
        }
        $msg = strtolower($body['mensaje'] ?? '');
        if ($msg && !str_contains($msg, 'éxito') && !str_contains($msg, 'exito') && !str_contains($msg, 'success')) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        return redirect()->route('direcciones.index')->with('success', 'Dirección actualizada correctamente.');
    }

    /**
     * Elimina una dirección.
     * Corresponde a la ruta DELETE /direcciones/{cod_direcciones}
     */
    public function destroy($cod_direcciones): RedirectResponse
    {
        // Usa el ID del parámetro de la ruta para la URL de la API
        $response = Http::delete("{$this->api}/direccion/eliminardireccion/{$cod_direcciones}");

        if ($response->successful()) {
            return redirect()->route('direcciones.index')->with('success', 'Dirección eliminada correctamente.');
        } else {
            return redirect()->route('direcciones.index')->with('error', 'Error al eliminar la dirección.');
        }
    }
}