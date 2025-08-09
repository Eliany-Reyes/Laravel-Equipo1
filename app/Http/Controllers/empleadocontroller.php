<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class EmpleadoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetEmpleados()
    {
        $response = Http::get('http://localhost:3000/empleados/obtenertodos');
        $empleados = json_decode($response, true);
        return view('personas.empleados', compact('empleados'));
    }
}