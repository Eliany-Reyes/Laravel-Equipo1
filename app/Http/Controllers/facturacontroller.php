<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;




class FacturaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
     
    

    public function GetFacturas()
    {
        $response = Http::get('http://localhost:3000/factura/TodasFacturas');
          if ($response->successful()) {
        // Si es exitosa, decodifica el JSON de la respuesta
        $facturas = json_decode($response->body(), true);
            // ----------------------------------------------------
                // Lógica para ordenar el evento más reciente al inicio
                // ----------------------------------------------------
                if (!empty($facturas)) {
                    $latestValue = null;
                    $latestIndex = null;

                    foreach ($facturas as $index => $item) {
                        // Compara usando 'created_at' si existe
                        if (!empty($item['created_at'])) {
                            $value = strtotime($item['created_at']);
                        } elseif (!empty($item['cod_factura'])) {
                            // Si no hay fecha, usa el código de evento
                            $value = (int) $item['cod_factura'];
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
                        $latestItem = $facturas[$latestIndex];
                        unset($facturas[$latestIndex]); // Elimina el evento de su posición original
                        array_unshift($facturas, $latestItem); // Lo añade al inicio del array
                    }
                }
    } else {
        // Si no es exitosa, inicializa $facturas como un arreglo vacío
        $facturas = [];
        // Opcional: puedes agregar un mensaje de error a la sesión
        session()->flash('error', 'Error al obtener los facturas de la API. Inténtalo de nuevo más tarde.');
    }
        
        return view('moduloeventos.facturas', compact('facturas'));
    }  


     public function create()
    {
        return view('moduloeventos.nuevaFactura');
    }

    public function postFacturas(Request $request)
    {
        $validatedData = $request->validate([
            'cod_factura' => 'required',
            'cod_reserva' => 'required',
            'precio_evento' => 'required',
            'sub_Total' => 'required',
            'isv' => 'required|numeric',
            'total' => 'required|integer',
           
        ]);

        $response = Http::post('http://localhost:3000/factura/InsertarFactura', $request->all());

        if ($response->successful()) {
            return redirect()->route('factura.index')->with('success', 'Factura creado exitosamente.');
        } else {
            return redirect()->route('factura.index')->with('error', 'Error al crear el Factura.');
        }
    }

    public function edit($cod_factura)
    {
        try {
        // Obtener los datos del evento de la API
        $response = Http::get('http://localhost:3000/factura/FacturaId/' . $cod_factura);

            if ($response->successful()) {
            $facturas = $response->json();
            // Retornar la vista de edición con los datos del evento
            return view('moduloeventos.editarFactura', compact('facturas'));
            } else {
            return redirect()->route('factura.index')->with('error', 'No se encontró el factura.');
            }

        } catch (\Exception $e) {
            return redirect()->route('factura.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }
     
    public function updateFactura(Request $request, $cod_factura): RedirectResponse
    {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            
            'cod_reserva' => 'required|integer',
            'precio_evento' => 'required|numeric',
            'sub_Total' => 'required|numeric',
            'isv' => 'required|numeric',
            'total' => 'required|numeric',
            
        ]);
        
        // 2. Mapear los datos a los nombres que espera tu API de Node.js
        // ¡Importante! Asegúrate de que estos nombres coincidan exactamente con tu API.
        $payload = [
            'cod_reserva' => $validated['cod_reserva'],
            'precio_evento' => $validated['precio_evento'],
            'sub_Total' => $validated['sub_Total'],
            'isv' => $validated['isv'],
            'total' => $validated['total']?? '',
            
        ];

        // 3. Llamar a la API con el método PUT
        $response = Http::put("http://localhost:3000/factura/actualizarFactura/{$cod_factura}", $payload);

        // 4. Manejar la respuesta
        if ($response->successful()) {
            return redirect()
                ->route('factura.index')
                ->with('success', 'Factura actualizado correctamente.');
        } else {
            // Muestra el cuerpo de la respuesta para depurar errores de la API
            return redirect()
                ->back()
                ->with('error', 'Error al actualizar el Factura: ' . $response->body());
        }
    }

    public function destroy($id)
    {
        try {
            // Se envía una solicitud DELETE al endpoint de la API con el ID en la URL
            $response = Http::delete("http://localhost:3000/factura/factura/{$id}");

            if ($response->successful()) {
                return redirect()->route('factura.index')->with('success', 'Factura eliminado con éxito.');
            } else {
                Log::error('Error al eliminar factura desde la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Hubo un error al eliminar el factura.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al eliminar factura: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión.');
        }
    }




}