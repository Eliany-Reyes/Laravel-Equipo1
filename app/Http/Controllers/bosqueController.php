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
     *
     * 
     * @return \Illuminate\View\View
     */

/*FUNCION DEL MODULO BOSQUES PRINCIPAL */

public function indexModulos()
    {
        return view('bosques.modulos_bosques');
    }

    /**
     * 
     * 
     * @return \Illuminate\View\View
     * 
     */



/*FUNCION DEL MOSTRAR TODOS LOS BOSQUES */
public function getBosques()
{
    $bosques = []; 
    try {   
        $responseBosques = Http::get('http://localhost:3000/bosques');

        

    if ($responseBosques->successful()) {
        $bosques = $responseBosques->json();
        
 usort($bosques, function($a, $b) {
                return $b['cod_bosque'] <=> $a['cod_bosque'];
            });


        } else {
            
    session()->flash('error', 'Error al obtener bosques de la API. Código: ' . $responseBosques->status());
        }

    } catch (ConnectionException $e) {
            session()->flash('error', 'Error de conexión con el backend de la API en http://localhost:3000. Asegúrate de que el servidor esté activo y funcionando.');
        }
        return view('bosques.bosques', compact('bosques'));
    }

    /**
     * 
     * @return \Illuminate\View\View
     */

/*FUNCION QUE NOS SIRVE EN NUEVO BOSQUE (PARA CREAR EL NUMERO BOSQUE) */

public function create()
    {
        return view('bosques.nuevobosque');
    }

    /**
     *
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

/*FUNCION PARA INSERTAR UN NUEVO BOSQUE  */

public function postBosque(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'nombre_bosque' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'tipo_bosque' => 'required|string|max:255',
                'descripcion_bosque' => 'required|string',
                'estado_bosque' => 'required|string|max:255',
            ]);

            $response = Http::post('http://localhost:3000/bosques', $validatedData);

     if ($response->successful()) {
            return redirect()->route('bosques.index')->with('success', 'Bosque creado exitosamente.');
            } else {

                $errorMessage = $response->json()['message'] ?? 'Error desconocido al crear el bosque.';
                return redirect()->back()->with('error', $errorMessage)->withInput();
            }
        } catch (ConnectionException $e) {
        
            return redirect()->back()->with('error', 'No se pudo conectar con la API: ' . $e->getMessage())->withInput();
        } catch (\Illuminate\Validation\ValidationException $e) {

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Ocurrió un error inesperado: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * 
     * @param string $cod_bosque
     */

/*FUNCION PARA EDITAR UN BOSQUE SEGUN SU ID */

public function edit($cod_bosque)
    {
        try {
            $response = Http::get('http://localhost:3000/bosques/bosques/'.$cod_bosque);

            if ($response->successful()) {
                $bosques = $response->json();
                
                return view('bosques.editarBosques', compact('bosques'));
            } else {
                return redirect()->route('bosques.index')->with('error', 'No se encontró el bosque.');
            }
        } catch (\Exception $e) {
            return redirect()->route('bosques.index')->with('error', 'Error al conectar con el servidor.'. $e->getMessage());
        }
    }

    /**
     * 
     * @param Request $request
     * @param string $cod_bosque
     * @return \Illuminate\Http\RedirectResponse
     */

 /*FUNCION PARA ACTUALIZAR EL BOSQUE SEGUN LA EDICION */

public function updateBosque(Request $request, $cod_bosque): RedirectResponse
    {
        try {
        
            $validated = $request->validate([
                'nombre_bosque' => 'required|string|max:255',
                'departamento' => 'required|string|max:255',
                'tipo_bosque' => 'required|string|max:255',
                'descripcion_bosque' => 'required|string',
                'estado_bosque' => 'required|string|max:255',
            ]);

            $payload = [
                'nombre_bosque' => $validated['nombre_bosque'],
                'departamento' => $validated['departamento'],
                'tipo_bosque' => $validated['tipo_bosque'],
                'descripcion_bosque' => $validated['descripcion_bosque'],
                'estado_bosque' => $validated['estado_bosque']
            ];

            $response = Http::put("http://localhost:3000/bosques/{$cod_bosque}", $payload);

        
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