<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class DireccionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetDirecciones()
    {
        $response = Http::get('http://localhost:3000/direccion/obtenertodos'); // Nota: 'dirreciones' con doble 'r'
        $direcciones = json_decode($response, true);
        return view('personas.direcciones', compact('direcciones'));
    }
}