<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class TelefonoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetTelefonos()
    {
        $response = Http::get('http://localhost:3000/telefonos/obtenerTelefono');
        $telefonos =$response->json(); 
        return view('personas.telefonos', compact('telefonos'));
    }
}