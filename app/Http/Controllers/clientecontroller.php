<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class ClienteController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function GetClientes()
    {
        // Realiza la solicitud HTTP GET a la API para obtener clientes
        $response = Http::get('http://localhost:3000/clientes/obtenertodos');
        $clientes = json_decode($response, true);
        return view('personas.clientes', compact('clientes'));
    }
}