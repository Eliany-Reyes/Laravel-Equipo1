<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // IMPORTANTE para llamadas HTTP a la API

class PantallasController extends Controller
{
    public function index()
    {
        // Obtener todos los registros de pantallas desde la API
        $response = Http::get('http://localhost:3000/pantallas/ObtenerTodos');

        if ($response->successful()) {
            $pantallas = $response->json();
        } else {
            $pantallas = [];
        }

        return view('personas.pantallas', compact('pantallas'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $apiUrl = "http://localhost:3000/pantallas/insertar";
        $response = Http::post($apiUrl, $data);

        return $response->successful()
            ? redirect()->route('pantallas.index')->with('success', 'Pantalla creada correctamente')
            : redirect()->route('pantallas.index')->with('error', 'No se pudo crear la pantalla');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $apiUrl = "http://localhost:3000/pantallas/actualizar";
        $response = Http::put($apiUrl, $data);

        return $response->successful()
            ? redirect()->route('pantallas.index')->with('success', 'Pantalla actualizada correctamente')
            : redirect()->route('pantallas.index')->with('error', 'No se pudo actualizar la pantalla');
    }

    public function destroy($id)
    {
        $apiUrl = "http://localhost:3000/pantallas/{$id}";
        $response = Http::delete($apiUrl);

        return $response->successful()
            ? redirect()->route('pantallas.index')->with('success', 'Pantalla eliminada correctamente')
            : redirect()->route('pantallas.index')->with('error', 'No se pudo eliminar la pantalla');
    }
}