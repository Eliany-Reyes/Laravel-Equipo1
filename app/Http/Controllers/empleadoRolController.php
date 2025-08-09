<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class EmpleadoRolController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetEmpleadosRoles()
    {
        $response = Http::get('http://localhost:3000/empleadorol/obtenertodos');
        $empleados_roles = $response->json(); 
        return view('personas.empleados_roles', compact('empleados_roles'));
    }
}