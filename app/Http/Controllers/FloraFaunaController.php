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
     * ESTA FUNCIÓN VA A TRAER LA LISTA DE FLORA Y FAUNA DESDE MI API.
     */
    public function GetFloraFauna()
    {
        // INICIALIZO ESTA VARIABLE, POR SI ALGO FALLA CON LA API NO TENGA ERRORES
        $floraFauna = [];

        
        try {
           
            $response = Http::get('http://localhost:3000/bosques/flora_fauna');  // HAGO UNA PETICIÓN GET A LA URL DE MI API

       
            if ($response->successful()) {
                // SI TODO BIEN, DECODIFICO LA RESPUESTA DE LA API Y LA GUARDO
                $floraFauna = $response->json();
            } else {
                // SI ALGO SALIÓ MAL, MANDO UN MENSAJE DE ERROR A LA SESIÓN CON EL CÓDIGO
                session()->flash('error', 'Error al obtener datos de flora y fauna. Código de estado: ' . $response->status());
            }

        } catch (\Exception $e) {
            // SI HAY UN ERROR DE CONEXIÓN O CUALQUIER OTRA COSA, LO CAPTURO Y MANDO UN MENSAJE
            session()->flash('error', 'Error de conexión con la API de flora y fauna: ' . $e->getMessage());
        }

        // LE PASO LOS DATOS A LA VISTA, PARA QUE LOS PUEDA MOSTRAR
        return view('bosques.flora-fauna', compact('floraFauna'));
    }
}
