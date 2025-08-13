<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class EventoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
    public function GetEventos()
    {
        $response = Http::get('http://localhost:3000/eventos/obtenerTodos');
          if ($response->successful()) {
        // Si es exitosa, decodifica el JSON de la respuesta
        $eventos = json_decode($response->body(), true);
    } else {
        // Si no es exitosa, inicializa $eventos como un arreglo vacío
        $eventos = [];
        // Opcional: puedes agregar un mensaje de error a la sesión
        session()->flash('error', 'Error al obtener los eventos de la API. Inténtalo de nuevo más tarde.');
    }
        
        return view('moduloeventos.eventos', compact('eventos'));
    }  

    public function create()
    {
        return view('moduloeventos.nuevoevento');
    }

    public function postEventos(Request $request)
    {
        $validatedData = $request->validate([
            'cod_evento' => 'required',
            'cod_bosque' => 'required',
            'tipo_evento' => 'required',
            'descripcion_evento' => 'required',
            'precio_evento' => 'required|numeric',
            'cantidad_maxima' => 'required|integer',
            'restricciones' => 'required',
        ]);

        $response = Http::post('http://localhost:3000/eventos/insertarEvento', $request->all());

        if ($response->successful()) {
            return redirect()->route('eventos.index')->with('success', 'Evento creado exitosamente.');
        } else {
            return redirect()->route('eventos.index')->with('error', 'Error al crear el evento.');
        }
    }



    public function edit($cod_evento)
    {
        try {
        // Obtener los datos del evento de la API
        $response = Http::get('http://localhost:3000/eventos/obtenerPorId/' . $cod_evento);

            if ($response->successful()) {
            $eventos = $response->json();
            // Retornar la vista de edición con los datos del evento
            return view('moduloeventos.editarEventos', compact('eventos'));
            } else {
            return redirect()->route('eventos.index')->with('error', 'No se encontró el evento.');
            }

        } catch (\Exception $e) {
            return redirect()->route('eventos.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }
     
    public function updateEventos(Request $request, $cod_evento): RedirectResponse
    {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'cod_bosque' => 'required|integer',
            'tipo_evento' => 'required|string|max:255',
            'descripcion_evento' => 'required|string|max:255',
            'precio_evento' => 'required|numeric',
            'cantidad_maxima' => 'required|integer|min:0',
            'restricciones' => 'nullable|string',
        ]);
        
        // 2. Mapear los datos a los nombres que espera tu API de Node.js
        // ¡Importante! Asegúrate de que estos nombres coincidan exactamente con tu API.
        $payload = [
            'cod_bosque' => $validated['cod_bosque'],
            'tipo_evento' => $validated['tipo_evento'],
            'descripcion_evento' => $validated['descripcion_evento'],
            'precio_evento' => $validated['precio_evento'],
            'cantidad_maxima' => $validated['cantidad_maxima'],
            'restricciones' => $validated['restricciones'] ?? '',
        ];

        // 3. Llamar a la API con el método PUT
        $response = Http::put("http://localhost:3000/eventos/actualizarEvento/{$cod_evento}", $payload);

        // 4. Manejar la respuesta
        if ($response->successful()) {
            return redirect()
                ->route('eventos.index')
                ->with('success', 'Evento actualizado correctamente.');
        } else {
            // Muestra el cuerpo de la respuesta para depurar errores de la API
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el evento: ' . $response->body());
        }
    }


     public function destroy($id)
    {
        try {
            // Se envía una solicitud DELETE al endpoint de la API con el ID en la URL
            $response = Http::delete("http://localhost:3000/eventos/evento/{$id}");

            if ($response->successful()) {
                return redirect()->route('eventos.index')->with('success', 'Evento eliminado con éxito.');
            } else {
                Log::error('Error al eliminar evento desde la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Hubo un error al eliminar el evento.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al eliminar evento: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión.');
        }
    }


}