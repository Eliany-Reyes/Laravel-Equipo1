<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Client\ConnectionException;

class BosqueController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    /**
     * Muestra la pantalla del menú de opciones para el módulo de bosques.
     * Esta es la vista principal del módulo de bosques.
     * @return \Illuminate\View\View
     */
    public function indexModulos()
    {
        // Se corrige la ruta de la vista para que apunte a la subcarpeta 'bosques'
        return view('bosques.modulos_bosques');
    }

    /**
     * Muestra la vista de gestión de bosques con los datos de los bosques.
     * Esta función llama a la API de backend para obtener los datos y muestra el listado.
     * @return \Illuminate\View\View
     */
    public function getBosques()
    {
        // Se inicializan las variables con arrays vacías para evitar errores
        $bosques = [];
        
        try {
            // Se realiza solo una llamada a la API para obtener los bosques
            $responseBosques = Http::get('http://localhost:3000/bosques');
            
            // Verifica si la respuesta de la API fue exitosa (código 2xx)
            if ($responseBosques->successful()) {
                $bosques = $responseBosques->json();
            } else {
                // Si la API responde con un error, se guarda un mensaje en la sesión
                session()->flash('error', 'Error al obtener bosques de la API. Código: ' . $responseBosques->status());
            }

        } catch (ConnectionException $e) {
            // Captura errores si no se puede conectar con el servidor de la API (ej: servidor apagado)
            session()->flash('error', 'Error de conexión con el backend de la API en http://localhost:3000. Asegúrate de que el servidor esté activo y funcionando.');
        }

        // Pasa las variables a la vista, incluso si están vacías debido a un error
        return view('bosques.bosques', compact('bosques'));
    }

    /**
     * Muestra la vista para crear un nuevo bosque.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('bosques.nuevobosque');
    }

    /**
     * Procesa la inserción de un nuevo bosque.
     * Ahora el cod_bosque se asume que es auto-incrementable y no se valida.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postBosque(Request $request): RedirectResponse
    {
        try {
            // 1. Validar los datos del formulario, excluyendo cod_bosque
            $validatedData = $request->validate([
                'nombre_bosque' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'tipo_bosque' => 'required|string|max:255',
                'descripcion_bosque' => 'required|string',
                'estado_bosque' => 'required|string|max:255',
            ]);

            // 2. Enviar solo los datos validados a la API de Node.js
            $response = Http::post('http://localhost:3000/bosques', $validatedData);

            // 3. Manejar la respuesta de la API
            if ($response->successful()) {
                return redirect()->route('bosques.index')->with('success', 'Bosque creado exitosamente.');
            } else {
                // Capturar el mensaje de error de la API si está disponible
                $errorMessage = $response->json()['message'] ?? 'Error desconocido al crear el bosque.';
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        } catch (ConnectionException $e) {
            // 4. Capturar errores de conexión
            return redirect()->back()->with('error', 'No se pudo conectar con la API: ' . $e->getMessage())->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 5. Capturar errores de validación de Laravel
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // 6. Capturar cualquier otra excepción
            return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Muestra el formulario para editar un bosque específico.
     * @param string $cod_bosque
     */
    public function edit($cod_bosque)
    {
        try {
            // Obtener los datos del bosque de la API
            $response = Http::get('http://localhost:3000/bosques/bosques/'.$cod_bosque);

            if ($response->successful()) {
                $bosques = $response->json();
                
                // Retornar la vista de edición con los datos del bosque
                return view('bosques.editarBosques', compact('bosques'));
            } else {
                return redirect()->route('bosques.index')->with('error', 'No se encontró el bosque.');
            }
        } catch (\Exception $e) {
            return redirect()->route('bosques.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }

    /**
     * Actualiza un bosque específico.
     * @param Request $request
     * @param string $cod_bosque
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateBosque(Request $request, $cod_bosque): RedirectResponse
    {
        try {
            // 1. Validar los datos del formulario
            $validated = $request->validate([
                'nombre_bosque' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'tipo_bosque' => 'required|string|max:255',
                'descripcion_bosque' => 'required|string',
                'estado_bosque' => 'required|string|max:255',
            ]);

            // 2. Mapear los datos a los nombres que espera tu API de Node.js
            $payload = [
                'nombre_bosque' => $validated['nombre_bosque'],
                'departamento' => $validated['departamento'],
                'tipo_bosque' => $validated['tipo_bosque'],
                'descripcion_bosque' => $validated['descripcion_bosque'],
                'estado_bosque' => $validated['estado_bosque']
            ];

            // 3. Llamar a la API con el método PUT
            $response = Http::put("http://localhost:3000/bosques/{$cod_bosque}", $payload);

            // 4. Manejar la respuesta
            if ($response->successful()) {
                return redirect()->route('bosques.index')->with('success', 'Bosque actualizado correctamente.');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Error al actualizar el bosque.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al actualizar el bosque: ' . $e->getMessage());
        }
    }
}