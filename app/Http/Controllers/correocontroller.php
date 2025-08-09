<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class CorreoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function GetCorreos()
    {
        $response = Http::get('http://localhost:3000/correos/obtenertodos');
        $correos = json_decode($response, true);
        return view('personas.correos', compact('correos'));
    }
}