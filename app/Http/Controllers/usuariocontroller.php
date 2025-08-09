<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function GetUsuario()
    {
       /* $infor = Http::get('http://127.0.0.1:3000/personas'); 
        $personas =  $infor->json();
        return view('Personas.persona', compact('personas'));*/
        

        $response = Http::get('http://localhost:3000/usuarios/obtenertodos');
        $usuarios = json_decode($response, true);
        return view('personas.usuarios', compact('usuarios'));

    
    }
}