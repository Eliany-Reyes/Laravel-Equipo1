<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class PermisoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetPermisos()
    {
        $response = Http::get('http://localhost:3000/permisos/obtenertodos');
        $permisos = json_decode($response, true);
        return view('personas.permisos', compact('permisos'));
    }
}