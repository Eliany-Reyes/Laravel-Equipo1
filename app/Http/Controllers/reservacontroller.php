<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
 

class ReservaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
     

    public function GetReservas()
    {
        $response = Http::get('http://localhost:3000/reserva/obtenerTodasReservas');
          if ($response->successful()) {
        // Si es exitosa, decodifica el JSON de la respuesta
        $reservas = json_decode($response->body(), true);
            // ----------------------------------------------------
                // Lógica para ordenar el evento más reciente al inicio
                // ----------------------------------------------------
                if (!empty($reservas)) {
                    $latestValue = null;
                    $latestIndex = null;

                    foreach ($reservas as $index => $item) {
                        // Compara usando 'created_at' si existe
                        if (!empty($item['created_at'])) {
                            $value = strtotime($item['created_at']);
                        } elseif (!empty($item['cod_reserva'])) {
                            // Si no hay fecha, usa el código de evento
                            $value = (int) $item['cod_reserva'];
                        } else {
                            $value = null;
                        }

                        // Encuentra el evento con el valor más alto (más reciente)
                        if ($value !== null && ($latestValue === null || $value > $latestValue)) {
                            $latestValue = $value;
                            $latestIndex = $index;
                        }
                    }

                    // Si se encontró el evento más reciente y no es el primero, lo mueve al inicio
                    if ($latestIndex !== null && $latestIndex !== 0) {
                        $latestItem = $reservas[$latestIndex];
                        unset($reservas[$latestIndex]); // Elimina el evento de su posición original
                        array_unshift($reservas, $latestItem); // Lo añade al inicio del array
                    }
                }
    } else {
        // Si no es exitosa, inicializa $reservas como un arreglo vacío
        $reservas = [];
        // Opcional: puedes agregar un mensaje de error a la sesión
        session()->flash('error', 'Error al obtener los reservas de la API. Inténtalo de nuevo más tarde.');
    }
        
        return view('moduloeventos.reservas', compact('reservas'));
    }  

     public function create()
    {
        return view('moduloeventos.nuevaReserva');
    }

    public function postReserva(Request $request)
    {
        $validatedData = $request->validate([
            'cod_reserva' => 'required',
            'cod_evento' => 'required',
            'cod_persona' => 'required',
            'hora_reserva' => 'required',
            'dia_reserva' => 'required',
            'cant_persona' => 'required',
            'isv_reserva' => 'required|numeric',
            'sub_total' => 'required|integer',
           
        ]);

        $response = Http::post('http://localhost:3000/reserva/InsertarReserva', $request->all());

        if ($response->successful()) {
            return redirect()->route('reserva.index')->with('success', 'Reserva creado exitosamente.');
        } else {
            return redirect()->route('reserva.index')->with('error', 'Error al crear el Reserva.');
        }
    }

    public function edit($cod_reserva)
    {
        try {
        // Obtener los datos del evento de la API
        $response = Http::get('http://localhost:3000/reserva/obtenerReservaId/' . $cod_reserva);

            if ($response->successful()) {
            $reservas = $response->json();
            // Retornar la vista de edición con los datos del evento
            return view('moduloeventos.editarReserva', compact('reservas'));
            } else {
            return redirect()->route('reserva.index')->with('error', 'No se encontró el factura.');
            }

        } catch (\Exception $e) {
            return redirect()->route('reserva.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }
     
    public function updateReserva(Request $request, $cod_reserva): RedirectResponse
    {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
           
            'cod_evento' => 'required|integer',
            'cod_persona' => 'required|integer',
            'hora_reserva' => 'required',
            'dia_reserva' => 'required',
            'cant_persona' => 'required|numeric',
            'isv_reserva' => 'required|numeric',
            'sub_total' => 'required|integer',
            
        
            
        ]);
        
        // 2. Mapear los datos a los nombres que espera tu API de Node.js
        // ¡Importante! Asegúrate de que estos nombres coincidan exactamente con tu API.
        $payload = [
            
            'cod_evento' => $validated['cod_evento'],
            'cod_persona' => $validated['cod_persona'],
            'hora_reserva' => $validated['hora_reserva'],
            'dia_reserva' => $validated['dia_reserva'],
            'cant_persona' => $validated['cant_persona'],
            'isv_reserva' => $validated['isv_reserva'],
            'sub_total' => $validated['sub_total'],
            
        ];

        // 3. Llamar a la API con el método PUT
        $response = Http::put("http://localhost:3000/reserva/actualizarReserva/{$cod_reserva}", $payload);

        // 4. Manejar la respuesta
        if ($response->successful()) {
            return redirect()
                 
                ->route('reserva.index')
                ->with('success', 'Reserva actualizado correctamente.');
        } else {
            
            // Muestra el cuerpo de la respuesta para depurar errores de la API
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el Reserva: ' . $response->body());
        }
    }


     public function destroy($id)
    {
        try {
            // Se envía una solicitud DELETE al endpoint de la API con el ID en la URL
            $response = Http::delete("http://localhost:3000/reserva/reserva/{$id}");

            if ($response->successful()) {
                return redirect()->route('reserva.index')->with('success', 'reserva eliminado con éxito.');
            } else {
                Log::error('Error al eliminar reserva desde la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Hubo un error al eliminar el reserva.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al eliminar reserva: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión.');
        }
    }

}