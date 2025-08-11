<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportesController extends Controller
{
    // Devuelve la vista reportes.blade.php sin datos (la tabla se llena por JS)
    public function index()
    {
        return view('reportes.reportes');
    }

    // Nueva función para devolver los datos JSON de los reportes
    public function obtenerReportesJson()
    {
        $apiUrl = "http://localhost:3000/Reportes";

        try {
            $response = Http::get($apiUrl);
            if ($response->successful()) {
                return response()->json($response->json());
            } else {
                return response()->json([], 500);
            }
        } catch (\Exception $e) {
            Log::error('Error al conectar con la API: ' . $e->getMessage());
            return response()->json([], 500);
        }
    }

    public function store(Request $request)
    {
        $apiUrl = "http://localhost:3000/Reportes";

        $validated = $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            // Si usas otros campos en el formulario agrégalos acá
        ]);

        try {
            $response = Http::post($apiUrl, $validated);

            if ($response->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => $response->body()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('id');  // Cambié 'cod_reporte' por 'id' para coincidir con tu JS
        $apiUrl = "http://localhost:3000/Reportes/{$id}";

        $validated = $request->validate([
            'titulo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
        ]);

        try {
            $response = Http::put($apiUrl, $validated);

            if ($response->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => $response->body()], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Método para eliminar reporte
    public function destroy($id)
    {
        $apiUrl = "http://localhost:3000/Reportes/{$id}";

        try {
            $response = Http::delete($apiUrl);

            if ($response->successful()) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['error' => 'Error al eliminar'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
