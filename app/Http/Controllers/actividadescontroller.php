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


class ActividadesController extends Controller
{
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // ESTA FUNCIÓN SOLO MUESTRA LA PANTALLA PRINCIPAL DEL MÓDULO
    public function indexModulos()
    {
        return view('actividades.pantalla');
    }
    
    /**
     * FUNCION QUE MUESTRA LA LISTA DE ACTIVIDADES Y BOSQUES
     */
    public function index()
    {
        
        $actividades = [];
        $bosques = [];

       
        try {
             
            $responseActividades = Http::get('http://localhost:3000/bosques/actividades');  // OBTENEMOS LAS ACTIVIDADES DESDE LA API
            // VERIFICAMOS SI LA PETICIÓN FUE EXITOSA
            if ($responseActividades->successful()) {
                // GUARDAMOS LOS DATOS COMO JSON
                $actividades = $responseActividades->json();

                 $actividades = array_reverse($actividades); // MUESTRA LOS DATOS INGRESADOS AL INICIO 
                 
            } else {
                // SI HAY UN ERROR, MANDAMOS UN MENSAJE A LA SESIÓN
                session()->flash('error', 'Error al obtener actividades. Código: ' . $responseActividades->status());
            }

    
            $responseBosques = Http::get('http://localhost:3000/bosques');       // OBTENEMOS LOS BOSQUES DESDE LA API
            if ($responseBosques->successful()) {
                $bosques = $responseBosques->json();
            } else {
                session()->flash('error', 'Error al obtener bosques. Código: ' . $responseBosques->status());
            }
        } catch (ConnectionException $e) {
          
            session()->flash('error', 'Error de conexión con la API. Verifica que el servidor esté activo.');
        }

       
        $actividades = array_map(function($actividad) {
            if (!isset($actividad['cod_actividad']) && isset($actividad['id'])) {
                $actividad['cod_actividad'] = $actividad['id'];
            }
            return $actividad;
        }, $actividades);

       
        return view('bosques.actividades', compact('actividades', 'bosques'));
    }


    /**
     * FUNCION QUE MUESTRA EL FORMULARIO PARA CREAR UNA NUEVA ACTIVIDAD
     */
    public function create()
    {
       
        $bosques = [];
        try {
         
            $response = Http::get('http://localhost:3000/bosques');    // OBTENEMOS LOS BOSQUES PARA EL SELECT EN EL FORMULARIO
            if ($response->successful()) {
                $bosques = $response->json();
            }
        } catch (ConnectionException $e) {
            
            session()->flash('error', 'No se pudo conectar para obtener bosques.');
        }

       
        return view('bosques.nuevaActividad', compact('bosques'));
    }

    
    /**
     * FUNCION QUE ALMACENA UNA NUEVA ACTIVIDAD EN LA API
     */
    public function store(Request $request)
    {
        // VALIDAMOS LOS DATOS DEL FORMULARIO
        $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'descripcion_actividad' => 'required|string',
            'espacios_disponibles' => 'required|integer|min:1',
        ]);

        try {
            // HACEMOS UNA PETICIÓN POST A LA API CON LOS DATOS VALIDADOS
            $response = Http::post('http://localhost:3000/bosques/actividades', [
                'codigo_bosque' => $request->input('cod_bosque'),
                'descripcion_actividad' => $request->input('descripcion_actividad'),
                'espacios_disponibles' => $request->input('espacios_disponibles'),
            ]);

            // MANEJAMOS LA RESPUESTA DE LA API
            if ($response->successful()) {
                // SI FUE EXITOSO, REDIRIGIMOS CON UN MENSAJE DE ÉXITO
                return redirect()->route('actividades.index')->with('success', 'Actividad creada exitosamente.');
            } else {
                // SI HUBO UN ERROR, REDIRIGIMOS CON EL MENSAJE DE ERROR
                $msg = $response->json()['message'] ?? 'Error desconocido al crear la actividad.';
                return redirect()->back()->with('error', $msg)->withInput();
            }
        } catch (Exception $e) {
            // SI FALLÓ LA CONEXIÓN, MOSTRAMOS UN MENSAJE DE ERROR
            return redirect()->back()->with('error', 'Error al conectar con la API: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * FUNCION QUE MUESTRA EL FORMULARIO PARA EDITAR UNA ACTIVIDAD
     */
    public function edit($cod_actividad)
    {
        try {
          
            $responseActividad = Http::get("http://localhost:3000/bosques/actividades/{$cod_actividad}");   // OBTENEMOS LOS DATOS DE LA ACTIVIDAD ESPECÍFICA
            $responseBosques = Http::get('http://localhost:3000/bosques');

            // SI AMBAS PETICIONES SON EXITOSAS
            if ($responseActividad->successful() && $responseBosques->successful()) {
                // GUARDAMOS LOS DATOS
                $actividad = $responseActividad->json();
                $bosques = $responseBosques->json();
                
                // RETORNAMOS LA VISTA CON LOS DATOS
                return view('bosques.editarActividades', compact('actividad', 'bosques'));
            } else {
                // SI HAY UN ERROR, REDIRIGIMOS CON UN MENSAJE
                return redirect()->route('actividades.index')->with('error', 'No se pudo cargar la actividad o la lista de bosques para editar.');
            }
        } catch (\Exception $e) {
            // MANEJAMOS ERRORES DE CONEXIÓN
            return redirect()->route('actividades.index')->with('error', 'Error al conectar con el servidor: ' . $e->getMessage());
        }
    }

    /**
     * FUNCION QUE ACTUALIZA UNA ACTIVIDAD A TRAVÉS DE LA API
     */
    public function updateActividad(Request $request, $cod_actividad)
    {
        // VALIDAMOS LOS DATOS DE ENTRADA
        $validatedData = $request->validate([
            'cod_bosque' => 'required|string|max:255',
            'descripcion_actividad' => 'required|string',
            'espacios_disponibles' => 'required|max:255',
        ]);

        try {
           
            $response = Http::put("http://localhost:3000/bosques/actividades/{$cod_actividad}", [  // REALIZAMOS UNA PETICIÓN PUT A LA API
                'codigo_bosque' => $validatedData['cod_bosque'],
                'descripcion_actividad' => $validatedData['descripcion_actividad'],
                'espacios_disponibles' => $validatedData['espacios_disponibles'],
            ]);

         
            if ($response->successful()) {
             
                return redirect()->route('actividades.index')->with('success', 'Actividad actualizada correctamente.');
            } else {
               
                $errorMessage = $response->json()['message'] ?? 'Error al actualizar el acceso.';
                return redirect()->back()->with('error', $errorMessage);
            }
        } catch (ConnectionException $e) {
           
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al actualizar el acceso.');
        }
    }

    /**
     * FUNCION QUE ELIMINA UNA ACTIVIDAD A TRAVÉS DE LA API
     */
    public function destroy($cod_actividad): RedirectResponse
    {
        try {
            
            $response = Http::delete("http://localhost:3000/bosques/actividades/{$cod_actividad}"); // HACEMOS UNA PETICIÓN DELETE A LA API

            
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