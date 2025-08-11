<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    public function index()
    {
        $apiUrl = "http://localhost:3000/Reportes";

        try {
            $response = Http::get($apiUrl);

            if ($response->successful()) {
                $reportes = $response->json();
                return view('reportes.reportes', [
                    'reportes' => $reportes,
                    'message' => 'Datos cargados correctamente.',
                ]);
            } else {
                return view('reportes.reportes', [
                    'reportes' => [],
                    'message' => 'Error al obtener reportes. Estado: ' . $response->status()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con la API: ' . $e->getMessage());
            return view('reportes', [
                'reportes' => [],
                'message' => 'Excepción: ' . $e->getMessage()
            ]);
        }
    }

    public function store(Request $request)
    {
        $apiUrl = "http://localhost:3000/Reportes";

        $validated = $request->validate([
            'titulo' => 'required|string|max:100',
            'tipo_reporte' => 'required|string|max:50',
            'generado_por' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'cod_grafico' => 'required|integer',
        ]);

        try {
            $response = Http::post($apiUrl, $validated);

            if ($response->successful()) {
                return redirect()->route('reportes.index')->with('success', 'Reporte insertado correctamente.');
            } else {
                return redirect()->route('reportes.index')->with('error', 'Error al insertar: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->route('reportes.index')->with('error', 'Excepción: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
{
    $id = $request->input('cod_reporte');
    $apiUrl = "http://localhost:3000/Reportes/{$id}";

    $validated = $request->validate([
        'titulo' => 'required|string|max:100',
        'tipo_reporte' => 'required|string|max:50',
        'generado_por' => 'required|string|max:50',
        'descripcion' => 'nullable|string',
        'cod_grafico' => 'required|integer',
    ]);

    try {
        $response = Http::put($apiUrl, $validated);

        if ($response->successful()) {
            return redirect()->route('reportes.index')->with('success', 'Reporte actualizado correctamente.');
        } else {
            return redirect()->route('reportes.index')->with('error', 'Error al actualizar: ' . $response->body());
        }
    } catch (\Exception $e) {
        return redirect()->route('reportes.index')->with('error', 'Excepción: ' . $e->getMessage());
    }
}
}