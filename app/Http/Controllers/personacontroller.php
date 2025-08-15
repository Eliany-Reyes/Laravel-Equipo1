<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PersonaController extends Controller
{
    // GET /personas -> Obtener todos los registros
    public function index()
    {
        $response = Http::get('http://localhost:3000/personas/obtenertodos');
        $personas = $response->json();

        if (!is_array($personas)) {
            $personas = [];
        }

        return view('personas.personas', compact('personas'));
    }

    // POST /personas/guardar -> Insertar un nuevo registro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'edad'             => 'required|integer|min:0',
            'peso'             => 'required|numeric|min:0',
            'estado_civil'     => 'nullable|string|max:50',
            'nacionalidad'     => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero'           => 'nullable|string|max:20',
            'idioma_persona'   => 'nullable|string|max:50',
        ]);
        
        $resp = Http::post('http://127.0.0.1:3000/personas/insertarpersonas', $validated);

        if ($resp->failed()) {
            return redirect()->back()->with('error', 'Error al insertar persona: ' . $resp->body());
        }

        return redirect()->route('personas.index')->with('success', 'Persona insertada correctamente.');
    }

    // PUT /personas/{cod_persona}/actualizar -> Actualizar un registro existente
    public function update(Request $request, $cod_persona)
    {
        $validated = $request->validate([
            'nombre'           => 'required|string|max:100',
            'apellido'         => 'required|string|max:100',
            'edad'             => 'required|integer|min:0',
            'peso'             => 'required|numeric|min:0',
            'estado_civil'     => 'nullable|string|max:50',
            'nacionalidad'     => 'nullable|string|max:100',
            'fecha_nacimiento' => 'nullable|date',
            'genero'           => 'nullable|string|max:20',
            'idioma_persona'   => 'nullable|string|max:50',
        ]);

        $datos = array_merge($validated, ['cod_persona' => $cod_persona]);
        
        $resp = Http::put('http://localhost:3000/personas/actualizarpersona', $datos);

        if ($resp->failed()) {
            return redirect()->back()->with('error', 'Error al actualizar persona: ' . $resp->body());
        }

        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente.');
    }
}