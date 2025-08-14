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

class ActividadesController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function indexModulos()
    {
        // Se corrige la ruta de la vista para que apunte a la subcarpeta 'actividades'
        return view('actividades.modulos_actividades');
    }
    
    /**
     * Mostrar listado de actividades junto con bosques.
     */
    public function index()
    {
        $actividades = [];
        $bosques = [];

        try {
            $responseActividades = Http::get('http://localhost:3000/bosques/actividades');
            if ($responseActividades->successful()) {
                $actividades = $responseActividades->json();
            } else {
                session()->flash('error', 'Error al obtener actividades. Código: ' . $responseActividades->status());
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

        return view('bosques.actividades', compact('actividades', 'bosques'));
    }

    /**
     * Mostrar formulario para crear una nueva actividad.
     */
    public function create()
    {
        // Para mostrar bosques en el formulario, traemos lista de bosques
        $bosques = [];
        try {
            $response = Http::get('http://localhost:3000/bosques');
            if ($response->successful()) {
                $bosques = $response->json();
            }
        } catch (ConnectionException $e) {
            session()->flash('error', 'No se pudo conectar para obtener bosques.');
        }

        return view('bosques.nuevaActividad', compact('bosques'));
    }

    /**
     * Guardar nueva actividad en la API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'descripcion_actividad' => 'required|string',
            'espacios_disponibles' => 'required|integer|min:1',
        ]);

        try {
            $response = Http::post('http://localhost:3000/bosques/actividades', [
                'codigo_bosque' => $request->input('cod_bosque'),
                'descripcion_actividad' => $request->input('descripcion_actividad'),
                'espacios_disponibles' => $request->input('espacios_disponibles'),
            ]);

            if ($response->successful()) {
                return redirect()->route('actividades.index')->with('success', 'Actividad creada exitosamente.');
            } else {
                $msg = $response->json()['message'] ?? 'Error desconocido al crear la actividad.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Muestra el formulario para editar una actividad específica.
     * @param string $cod_actividad
     */
    public function edit($cod_actividad)
    {
        try {
            // Obtener los datos del bosque de la API
            $response = Http::get('http://localhost:3000/bosques/actividades/'.$cod_actividad);
            
            // También necesitamos la lista de bosques para el formulario
            $responseBosques = Http::get('http://localhost:3000/bosques');
            
            if ($response->successful() && $responseBosques->successful()) {
                $actividades = $response->json();
                $bosques = $responseBosques->json();
                
                // Retornar la vista de edición con los datos de la actividad y los bosques
                return view('bosques.editarActividades', compact('actividades', 'bosques'));
            } else {
                dd($response->body());
                return redirect()->route('actividades.index')->with('error', 'No se encontró el actividad.');
            }
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }

    /**
     * Actualiza una actividad específica.
     * @param Request $request
     * @param string $cod_actividad
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cod_actividad): RedirectResponse
    {
        try {
            // 1. Validar los datos del formulario
            $validated = $request->validate([
                'cod_bosque' => 'required|string|max:255',
                'descripcion_actividad' => 'required|string',
                'espacios_disponibles' => 'required|integer|min:1',
            ]);

            // 2. Mapear los datos a los nombres que espera tu API de Node.js
            $payload = [
                'codigo_bosque' => $validated['cod_bosque'],
                'descripcion_actividad' => $validated['descripcion_actividad'],
                'espacios_disponibles' => $validated['espacios_disponibles'],
            ];

            // 3. Llamar a la API con el método PUT
            $response = Http::put("http://localhost:3000/actividades/{$cod_actividad}", $payload);

            // 4. Manejar la respuesta
            if ($response->successful()) {
                return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al actualizar el bosque.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al actualizar el bosque: ' . $e->getMessage());
        }
    }
    
    /**
     * Elimina una actividad específica de la API.
     * @param string $cod_actividad
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cod_actividad): RedirectResponse
    {
        try {
            $response = Http::delete("http://localhost:3000/actividades/{$cod_actividad}");

            if ($response->successful()) {
                return redirect()->route('actividades.index')->with('success', 'Actividad eliminada exitosamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al eliminar la actividad.';
                return redirect()->route('actividades.index')->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->route('actividades.index')->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}
