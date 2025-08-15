<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\RedirectResponse;

class AccesoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Muestra el listado de accesos junto con los bosques.
     */
    public function getAccesos()
    {
        $accesos = [];
        $bosques = [];

        try {
            $responseAccesos = Http::get('http://localhost:3000/bosques/acceso');
            if ($responseAccesos->successful()) {
                $accesos = $responseAccesos->json();
            } else {
                session()->flash('error', 'Error al obtener accesos. Código: ' . $responseAccesos->status());
            }

            $responseBosques = Http::get('http://localhost:3000/bosques');
            if ($responseBosques->successful()) {
                $bosques = $responseBosques->json();
            } else {
                session()->flash('error', 'Error al obtener bosques. Código: ' . $responseBosques->status());
            }

        } catch (ConnectionException $e) {
            session()->flash('error', 'Error de conexión con la API. Verifica que el servidor esté activo.');
        }

        return view('bosques.acceso', compact('accesos', 'bosques'));
    }

    /**
     * Muestra la vista con el formulario para crear un nuevo acceso.
     */
    public function createAcceso()
    {
        $bosques = [];
        try {
            $responseBosques = Http::get('http://localhost:3000/bosques');
            $bosques = $responseBosques->successful() ? $responseBosques->json() : [];
        } catch (ConnectionException $e) {
            session()->flash('error', 'Error al conectar con la API de bosques.');
        }

        return view('accesos.nuevoaAcceso', compact('bosques'));
    }

    /**
     * Guarda un nuevo acceso en la API.
     */
    public function storeAcceso(Request $request)
    {
        $validatedData = $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'tipo_ruta' => 'required|string',
            'estado_ruta' => 'required|string',
            'recomendaciones' => 'required|string',
        ]);

        try {
            $response = Http::post('http://localhost:3000/bosques/acceso', $validatedData);

            if ($response->successful()) {
                return redirect()->route('acceso.list')->with('success', 'Acceso creado exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error desconocido al crear el acceso.';
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', 'No se pudo conectar con la API para crear el acceso.')->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un acceso específico.
     * @param string $cod_acceso
     */
    public function editAcceso($cod_acceso)
    {
        try {
            $responseAcceso = Http::get("http://localhost:3000/bosques/acceso/{$cod_acceso}");
            $responseBosques = Http::get('http://localhost:3000/bosques');

            if ($responseAcceso->successful() && $responseBosques->successful()) {
                $acceso = $responseAcceso->json();
                $bosques = $responseBosques->json();
                return view('accesos.editaracceso', compact('acceso', 'bosques'));
            } else {
                return redirect()->route('acceso.list')->with('error', 'No se encontró el acceso o los bosques.');
            }
        } catch (ConnectionException $e) {
            return redirect()->route('acceso.list')->with('error', 'Error al conectar con el servidor.');
        }
    }

    /**
     * Actualiza un acceso específico.
     * @param Request $request
     * @param string $cod_acceso
     * @return RedirectResponse
     */
    public function updateAcceso(Request $request, $cod_acceso)
    {
        $validatedData = $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'tipo_ruta' => 'required|string',
            'estado_ruta' => 'required|string',
            'recomendaciones' => 'required|string',
        ]);

        try {
            $response = Http::put("http://localhost:3000/bosques/acceso/{$cod_acceso}", $validatedData);

            if ($response->successful()) {
                return redirect()->route('acceso.list')->with('success', 'Acceso actualizado correctamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al actualizar el acceso.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (ConnectionException $e) {
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al actualizar el acceso.');
        }
    }

    /**
     * Elimina un acceso específico de la API.
     * @param string $cod_acceso
     * @return RedirectResponse
     */
    public function destroyAcceso($cod_acceso)
    {
        try {
            $response = Http::delete("http://localhost:3000/bosques/acceso/{$cod_acceso}");

            if ($response->successful()) {
                return redirect()->route('acceso.list')->with('success', 'Acceso eliminado exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al eliminar el acceso.';
                return redirect()->route('acceso.list')->with('error', $errorMessage);
            }
        } catch (ConnectionException $e) {
            return redirect()->route('acceso.list')->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}