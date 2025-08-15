<?php

namespace App\Http\Controllers;

// IMPORTAMOS CLASES NECESARIAS DE LARAVEL
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\RedirectResponse;

// DECLARAMOS LA CLASE DEL CONTROLADOR
class AccesoController extends Controller
{
   
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * FUNCIÓN PARA OBTENER TODOS LOS ACCESOS Y BOSQUES.
     */
    public function getAccesos()
    {
        
        $accesos = [];
        $bosques = [];

       
        try {
            $responseAccesos = Http::get('http://localhost:3000/bosques/acceso');  // HACEMOS UNA PETICIÓN GET A LA API PARA OBTENER LOS ACCESOS
          
            if ($responseAccesos->successful()) {   
                
                $accesos = $responseAccesos->json();
                 $accesos = array_reverse($accesos); // LÍNEA AÑADIDA
            } else {
              
                session()->flash('error', 'Error al obtener accesos. Código: ' . $responseAccesos->status());
            }

            
            $responseBosques = Http::get('http://localhost:3000/bosques'); // HACEMOS OTRA PETICIÓN GET PARA OBTENER LOS BOSQUES
            if ($responseBosques->successful()) {
               
                $bosques = $responseBosques->json();
            } else {
                
                session()->flash('error', 'Error al obtener bosques. Código: ' . $responseBosques->status());
            }
       
        } catch (ConnectionException $e) {
            
            session()->flash('error', 'Error de conexión con la API. Verifica que el servidor esté activo.');
        }

        // RETORNAMOS LA VISTA CON LOS DATOS OBTENIDOS
        return view('bosques.acceso', compact('accesos', 'bosques'));
    }

    /**
     * MUESTRA EL FORMULARIO PARA CREAR UN NUEVO ACCESO.
     */
    public function create()
    {
       
        $bosques = [];
        try {
            $responseBosques = Http::get('http://localhost:3000/bosques');   // PETICIÓN GET A LA API PARA OBTENER LOS BOSQUES
         
            $bosques = $responseBosques->successful() ? $responseBosques->json() : [];
        } catch (ConnectionException $e) {
           
            session()->flash('error', 'Error al conectar con la API de bosques.');
        }

        // RETORNAMOS LA VISTA PARA CREAR UN NUEVO ACCESO CON LOS DATOS DE LOS BOSQUES
        return view('bosques.nuevoacceso', compact('bosques'));
    }

    /**
     * ALMACENA UN NUEVO ACCESO EN LA BASE DE DATOS A TRAVÉS DE LA API.
     */
    public function store(Request $request)
    {
        // VALIDAMOS LOS DATOS QUE VIENEN DEL FORMULARIO
        $validatedData = $request->validate([
            'cod_bosque' => 'required|string',
            'tipo_ruta' => 'required|string',
            'estado_ruta' => 'required|string',
            'recomendaciones' => 'required|string',
        ]);

        try {
            // ENVIAMOS LOS DATOS VALIDADOS A LA API MEDIANTE UN POST
            $response = Http::post('http://localhost:3000/bosques/acceso', [
              
                'codigo_bosque' => $validatedData['cod_bosque'],
                'tipo_ruta' => $validatedData['tipo_ruta'],
                'estado_ruta' => $validatedData['estado_ruta'],
                'recomendaciones' => $validatedData['recomendaciones'],
            ]);

            // VERIFICAMOS SI LA INSERCIÓN FUE EXITOSA
            if ($response->successful()) {
                // REDIRIGIMOS A LA VISTA PRINCIPAL CON UN MENSAJE DE ÉXITO
                return redirect()->route('acceso.index')->with('success', 'Acceso creado exitosamente.');
            } else {
                // SI HUBO UN ERROR EN LA API, LO MOSTRAMOS
                $errorMessage = $response->json()['message'] ?? 'Error desconocido al crear el acceso.';
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        } catch (ConnectionException $e) {
            // MANEJAMOS EL ERROR DE CONEXIÓN
            return redirect()->back()->with('error', 'No se pudo conectar con la API para crear el acceso.')->withInput();
        }
    }

    /**
     * MUESTRA EL FORMULARIO PARA EDITAR UN ACCESO EXISTENTE.
     */
    public function editAcceso($cod_acceso)
    {
        try {
            // OBTENEMOS EL ACCESO ESPECÍFICO POR SU CÓDIGO Y TAMBIÉN LA LISTA DE BOSQUES
            $responseAcceso = Http::get("http://localhost:3000/bosques/acceso/{$cod_acceso}");
            $responseBosques = Http::get('http://localhost:3000/bosques');

            // VERIFICAMOS QUE AMBAS PETICIONES HAYAN SIDO EXITOSAS
            if ($responseAcceso->successful() && $responseBosques->successful()) {
                // ASIGNAMOS LOS DATOS A VARIABLES
                $acceso = $responseAcceso->json();
                $bosques = $responseBosques->json();
                // RETORNAMOS LA VISTA DE EDICIÓN CON LOS DATOS
                return view('bosques.editarAcceso', compact('acceso', 'bosques'));
            } else {
                // SI HAY UN ERROR, REDIRIGIMOS CON UN MENSAJE
                return redirect()->route('acceso.index')->with('error', 'No se encontró el acceso o los bosques.');
            }
        } catch (ConnectionException $e) {
            // MANEJAMOS EL ERROR DE CONEXIÓN
            return redirect()->route('acceso.index')->with('error', 'Error al conectar con el servidor.');
        }
    }

    /**
     * ACTUALIZA UN ACCESO EXISTENTE A TRAVÉS DE LA API.
     */
    public function updateAcceso(Request $request, $cod_acceso)
    {
        // VALIDAMOS LOS DATOS RECIBIDOS
        $validatedData = $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'tipo_ruta' => 'required|string',
            'estado_ruta' => 'required|string',
            'recomendaciones' => 'required|string',
        ]);

        try {
            // HACEMOS UNA PETICIÓN PUT A LA API PARA ACTUALIZAR EL ACCESO
            $response = Http::put("http://localhost:3000/bosques/acceso/{$cod_acceso}", [
                'codigo_bosque' => $validatedData['cod_bosque'],
                'tipo_ruta' => $validatedData['tipo_ruta'],
                'estado_ruta' => $validatedData['estado_ruta'],
                'recomendaciones_acceso' => $validatedData['recomendaciones'] 
            ]);

            // MANEJAMOS LA RESPUESTA DE LA API
            if ($response->successful()) {
               
                return redirect()->route('acceso.index')->with('success', 'Acceso actualizado correctamente.');
            } else {
            
                $errorMessage = $response->json()['message'] ?? 'Error al actualizar el acceso.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (ConnectionException $e) {
        
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al actualizar el acceso.');
        }
    }

    /**
     * ELIMINA UN ACCESO ESPECÍFICO A TRAVÉS DE LA API.
     */
    public function destroyAcceso($cod_acceso)
    {
        try {
            // HACEMOS UNA PETICIÓN DELETE A LA API PARA ELIMINAR EL REGISTRO
            $response = Http::delete("http://localhost:3000/bosques/acceso/{$cod_acceso}");

            // VERIFICAMOS SI LA ELIMINACIÓN FUE EXITOSA
            if ($response->successful()) {
              
                return redirect()->route('acceso.index')->with('success', 'Acceso eliminado exitosamente.');
            } else {
                
                $errorMessage = $response->json()['message'] ?? 'Error al eliminar el acceso.';
                return redirect()->route('acceso.index')->with('error', $errorMessage);
            }
        } catch (ConnectionException $e) {
         
            return redirect()->route('acceso.index')->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage());
        }
    }
}