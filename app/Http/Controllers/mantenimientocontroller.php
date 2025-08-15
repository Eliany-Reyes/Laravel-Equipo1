<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class MantenimientoController extends Controller
{
    /**
     * Muestra una lista de los mantenimientos.
     *
     * @return \Illuminate\Http\Response
     */

    public function GetMantenimientos()
    {
      try {
            $response = Http::get('http://localhost:3000/mantenimientos/obtenertodos');
            
            // Si la llamada a la API fue exitosa
            if ($response->successful()) {
                $mantenimientos = json_decode($response->body(), true);
                if (!empty($mantenimientos)) {
                $latestIndex = 0;
                $latestValue = null;

                foreach ($mantenimientos as $index => $item) {
                    // Solo revisar created_at o cod_mantenimiento
                    if (!empty($item['created_at'])) {
                        $value = strtotime($item['created_at']);
                    } elseif (!empty($item['cod_mantenimiento'])) {
                        $value = (int) $item['cod_mantenimiento'];
                    } else {
                        $value = null;
                    }

                    // Comparar para encontrar el más reciente
                    if ($value !== null && ($latestValue === null || $value > $latestValue)) {
                        $latestValue = $value;
                        $latestIndex = $index;
                    }
                }

                // Mover el más reciente al inicio sin cambiar el orden del resto
                if ($latestIndex !== 0) {
                    $latestItem = $mantenimientos[$latestIndex];
                    unset($mantenimientos[$latestIndex]);
                    array_unshift($mantenimientos, $latestItem);
                }
            }
            } else {
                // Si la API responde con un error, registra y usa un array vacío
                Log::error('Error al obtener mantenimientos de la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                $mantenimientos = [];
            }
        } catch (Exception $e) {
            // Si la API esta desconectada, registra el error y usa un array vacío
            Log::error('Excepción al obtener mantenimientos de la API externa: ' . $e->getMessage());
            $mantenimientos = [];
        }

        return view('mantenimiento.mantenimientos', compact('mantenimientos'));
    }


     
     /**
     * Muestra el formulario para crear un nuevo mantenimiento.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mantenimiento.create');
    }

    /**
     * Guarda un nuevo mantenimiento a través de la API externa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        // Enviar la solicitud POST a la API externa con los datos del formulario
        $response = Http::post("http://localhost:3000/mantenimientos/insertarmantenimiento", $request->all());

        // Manejar la respuesta de la API
        if ($response->successful()) {
            // Si la API respondió con éxito, redirige a la vista principal
            return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento creado con éxito.');
        } else {
            // Si la respuesta no es exitosa, registra el error en el log de Laravel
            Log::error('Error al crear mantenimiento desde la API externa:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            // Devuelve a la página anterior con un mensaje de error 
            return back()->with('error', 'Hubo un error al crear el mantenimiento. Por favor, revisa los logs para más detalles.');
        }


    }
  
    /**
     * Muestra el formulario de edición con los datos del mantenimiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            // Se envía una solicitud POST al endpoint 'buscarporid' del backend
            // El ID se envía en el cuerpo (body) de la solicitud
            $response = Http::post("http://localhost:3000/mantenimientos/buscarporid", ['cod_mantenimiento' => $id]);

            if ($response->successful() && $response->json()) {
                $mantenimiento = $response->json();
                return view('mantenimiento.editar', compact('mantenimiento'));
            } else {
                Log::error('Error al obtener mantenimiento para edición:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Mantenimiento no encontrado o error en la API.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al buscar mantenimiento: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión. Asegúrate de que el backend de Node.js esté funcionando.');
        }
    }

    /**
     * Actualiza un mantenimiento a través de la API externa.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Se envía una solicitud PUT al endpoint 'actualizarmantenimientos' de tu backend
            // Los datos, incluyendo el ID, se envían en el cuerpo (body) de la solicitud
            $response = Http::put("http://localhost:3000/mantenimientos/actualizarmantenimientos", $request->all());


            if ($response->successful()) {
                return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento actualizado con éxito.');
            } else {
                Log::error('Error al actualizar mantenimiento desde la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Hubo un error al actualizar el mantenimiento.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al actualizar mantenimiento: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión.');
        }
    }

      /**
     * Elimina un mantenimiento a través de la API externa.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // Se envía una solicitud DELETE al endpoint de la API con el ID en la URL
            $response = Http::delete("http://localhost:3000/mantenimientos/eliminarmantenimiento/{$id}");

            if ($response->successful()) {
                return redirect()->route('mantenimientos.index')->with('success', 'Mantenimiento eliminado con éxito.');
            } else {
                Log::error('Error al eliminar mantenimiento desde la API externa:', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return back()->with('error', 'Hubo un error al eliminar el mantenimiento.');
            }
        } catch (Exception $e) {
            Log::error('Excepción al eliminar mantenimiento: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión.');
        }
    }

    public function indexPantalla()
    {
        return view('pantalla-mantenimiento');
    }

}


