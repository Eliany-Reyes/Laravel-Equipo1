<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class FloraFaunaController extends BaseController
{
    /**
     * Muestra el listado de flora y fauna obtenida de una API.
     */
    public function GetFloraFauna()
    {
        $floraFauna = []; // Inicializamos la variable para evitar errores si la llamada a la API falla

        try {
            // Realiza una petición GET a la API en el endpoint correcto.
            // Asegúrate de que esta URL sea la de tu backend.
            $response = Http::get('http://localhost:3000/bosques/flora_fauna');

            // Verifica si la petición fue exitosa
            if ($response->successful()) {
                // Decodifica la respuesta JSON y la asigna a la variable
                $floraFauna = $response->json();
            } else {
                // Si la petición no fue exitosa, puedes manejar el error
                // Por ejemplo, mostrar un mensaje o loguear el error
                // Para este ejemplo, simplemente se dejará $floraFauna como un array vacío
                session()->flash('error', 'Error al obtener datos de flora y fauna. Código de estado: ' . $response->status());
            }

        } catch (\Exception $e) {
            // Captura cualquier excepción, como un error de conexión
            session()->flash('error', 'Error de conexión con la API de flora y fauna: ' . $e->getMessage());
        }

        // Pasa los datos (incluso si está vacío) a la vista.
        // La ruta de la vista debe ser 'bosques.flora-fauna' para que funcione.
        return view('bosques.flora-fauna', compact('floraFauna'));
    }
}
