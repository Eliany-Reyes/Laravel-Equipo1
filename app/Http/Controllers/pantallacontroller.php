<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class PantallaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetPantallas()
    {
        $response = Http::get('http://localhost:3000/pantallas/ObtenerTodos');
        $pantallas = json_decode($response, true);
        return view('personas.pantallas', compact('pantallas'));
    }
}