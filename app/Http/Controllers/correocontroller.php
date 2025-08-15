<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class CorreoController extends Controller
{
    // Define la URL base de la API externa para los correos.
    // Ajusta este host/puerto si tu API se ejecuta en una ubicación diferente.
    private string $api = 'http://localhost:3000';

    /**
     * Muestra una lista de correos obtenida de la API externa.
     *
     * @return \Illuminate\View\View
     */
    public function GetCorreos()
    {
        // Realiza una solicitud GET a la API para obtener todos los correos.
        $response = Http::get("{$this->api}/correos/obtenertodos");
        $correos  = $response->json(); // Intenta decodificar la respuesta JSON.

        // Normaliza la respuesta de la API:
        // 1. Si la respuesta no es un array (ej. string JSON), intenta decodificarla.
        if (!is_array($correos)) {
            $correos = json_decode($response->body(), true) ?? [];
        }
        // 2. Si la API envuelve los datos en una clave 'data', extráelos.
        if (isset($correos['data']) && is_array($correos['data'])) {
            $correos = $correos['data'];
        }

        // Retorna la vista 'personas.correos' pasando los datos de los correos.
        // Asegúrate de que esta ruta de vista es correcta, es decir, el archivo está en
        // resources/views/personas/correos.blade.php
        return view('personas.correos', compact('correos'));
    }

    /**
     * Almacena un nuevo correo enviando los datos a la API externa.
     * Incluye validación de Laravel y manejo de errores de la API.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos del correo.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function StoreCorreo(Request $request): RedirectResponse
    {
        // Valida los datos de entrada del formulario.
        $validated = $request->validate([
            'cod_persona'          => 'required|integer|min:1',
            'correo_personal'      => 'nullable|email|max:50',
            'correo_empleado'      => 'nullable|email|max:50',
            'correo_secundario'    => 'nullable|email|max:50',
            'correo_institucional' => 'nullable|email|max:50',
            'observaciones'        => 'nullable|string|max:255', // Añadido max:255 para consistencia
        ]);

        // Regla de negocio: al menos uno de los campos de correo debe estar presente.
        if (
            empty($validated['correo_personal']) &&
            empty($validated['correo_empleado']) &&
            empty($validated['correo_secundario']) &&
            empty($validated['correo_institucional'])
        ) {
            // Si no hay ningún correo, redirige con un error y mantiene los datos de entrada.
            return back()->with('error', 'Debe ingresar al menos un correo.')->withInput();
        }

        // Prepara el payload con los nombres de parámetros que espera tu API Node.
        $payload = [
            'p_cod_persona'          => $validated['cod_persona'],
            'p_correo_personal'      => $validated['correo_personal'] ?? null,
            'p_correo_empleado'      => $validated['correo_empleado'] ?? null,
            'p_correo_secundario'    => $validated['correo_secundario'] ?? null,
            'p_correo_institucional' => $validated['correo_institucional'] ?? null,
            'p_observaciones'        => $validated['observaciones'] ?? null,
        ];

        // Realiza la solicitud POST a la API para insertar el correo.
        $response = Http::post("{$this->api}/correos/insertarcorreo", $payload);

        // Intenta decodificar el cuerpo de la respuesta para verificar mensajes de éxito/error de la API.
        $body = $response->json();
        if (!is_array($body)) {
            $body = json_decode($response->body(), true);
        }

        // Manejo de errores basado en la respuesta HTTP o el mensaje del cuerpo de la API.
        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al registrar: '.$response->body())->withInput();
        }
        // Asume que la API devuelve un 'mensaje' y que este debe contener 'exito' para ser exitoso.
        if (isset($body['mensaje']) && stripos($body['mensaje'], 'exito') === false) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        // Redirige con mensaje de éxito.
        return redirect()->route('correos.index')->with('success', 'Correo registrado correctamente.');
    }

    /**
     * Actualiza un correo existente enviando los datos a la API externa.
     * Incluye validación de Laravel y manejo de errores de la API.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos actualizados.
     * @param string $cod_correos El ID del correo a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function UpdateCorreo(Request $request, $cod_correos): RedirectResponse
    {
        // Valida los datos de entrada del formulario.
        $validated = $request->validate([
            'cod_persona'          => 'required|integer|min:1',
            'correo_personal'      => 'nullable|email|max:50',
            'correo_empleado'      => 'nullable|email|max:50',
            'correo_secundario'    => 'nullable|email|max:50',
            'correo_institucional' => 'nullable|email|max:50',
            'observaciones'        => 'nullable|string|max:255', // Añadido max:255 para consistencia
        ]);

        // Regla de negocio: al menos uno de los campos de correo debe estar presente.
        if (
            empty($validated['correo_personal']) &&
            empty($validated['correo_empleado']) &&
            empty($validated['correo_secundario']) &&
            empty($validated['correo_institucional'])
        ) {
            // Si no hay ningún correo, redirige con un error y mantiene los datos de entrada.
            return back()->with('error', 'Debe ingresar al menos un correo.')->withInput();
        }

        // Prepara el payload con los nombres de parámetros que espera tu API Node.
        $payload = [
            'p_cod_correos'          => (int)$cod_correos, // Se asegura de que sea un entero.
            'p_cod_persona'          => $validated['cod_persona'],
            'p_correo_personal'      => $validated['correo_personal'] ?? null,
            'p_correo_empleado'      => $validated['correo_empleado'] ?? null,
            'p_correo_secundario'    => $validated['correo_secundario'] ?? null,
            'p_correo_institucional' => $validated['correo_institucional'] ?? null,
            'p_observaciones'        => $validated['observaciones'] ?? null,
        ];

        // Realiza la solicitud PUT a la API para actualizar el correo.
        $response = Http::put("{$this->api}/correos/actualizarcorreo", $payload);

        // Intenta decodificar el cuerpo de la respuesta para verificar mensajes de éxito/error de la API.
        $body = $response->json();
        if (!is_array($body)) {
            $body = json_decode($response->body(), true);
        }

        // Manejo de errores basado en la respuesta HTTP o el mensaje del cuerpo de la API.
        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al actualizar: '.$response->body())->withInput();
        }
        // Asume que la API devuelve un 'mensaje' y que este debe contener 'exito' para ser exitoso.
        if (isset($body['mensaje']) && stripos($body['mensaje'], 'exito') === false) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        // Redirige con mensaje de éxito.
        return redirect()->route('correos.index')->with('success', 'Correo actualizado correctamente.');
    }

    // El método destroy (eliminar) no está en el código original que proporcionaste,
    // pero se incluiría aquí si lo implementaras en tu API y rutas.

    public function destroy($cod_correos): RedirectResponse
    {
        $response = Http::delete("{$this->api}/correos/{$cod_correos}/eliminar"); // Ajusta la URL de tu API

        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al eliminar: '.$response->body());
        }

        $body = $response->json();
        if (!is_array($body)) {
            $body = json_decode($response->body(), true);
        }

        if (isset($body['mensaje']) && stripos($body['mensaje'], 'exito') === false) {
            return back()->with('error', $body['mensaje']);
        }

        return redirect()->route('correos.index')->with('success', 'Correo eliminado correctamente.');
    }
    
}