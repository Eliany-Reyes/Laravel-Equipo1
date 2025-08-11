<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BackupController extends Controller
{
    // GET /backup
    public function index()
    {
        $response = Http::get('http://localhost:3000/backup/ObtenerTodos');
        $backups  = $response->json();

        if (!is_array($backups)) {
            $backups = json_decode($response->body(), true) ?? [];
        }
        // Si tu API devuelve { data: [...] } descomenta:
        // if (isset($backups['data']) && is_array($backups['data'])) $backups = $backups['data'];

        return view('personas.backups', compact('backups'));
    }

    // POST /backup/guardar
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_backup'  => 'required|date',
            'ruta_archivo'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'realizado_por' => 'required|string|max:100',
            'cod_usuario'   => 'required|integer|min:1',
        ]);

        // tu API Node (ajusta si tu endpoint es diferente)
        $resp = Http::post('http://127.0.0.1:3000/InsertarBackup', $validated);

        return $resp->successful()
            ? redirect()->route('backups.index')->with('success', 'Backup creado correctamente.')
            : redirect()->back()->with('error', 'Error al crear backup: '.$resp->body());
    }

    // PUT /backup/{cod_backup}/actualizar
    public function update(Request $request, $cod_backup)
    {
        $validated = $request->validate([
            'fecha_backup'  => 'required|date',
            'ruta_archivo'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'realizado_por' => 'required|string|max:100',
            'cod_usuario'   => 'required|integer|min:1',
        ]);

        if (!empty($validated['fecha_backup'])) {
            $validated['fecha_backup'] = date('Y-m-d H:i:s', strtotime($validated['fecha_backup']));
        }

        // Ajusta a la URL real de tu API para actualizar
        $resp = Http::put("http://localhost:3000/backup/ActualizarBackup/{$cod_backup}", [
            'p_fecha_backup'  => $validated['fecha_backup'],
            'p_ruta_archivo'  => $validated['ruta_archivo'],
            'p_descripcion'   => $validated['descripcion'] ?? '',
            'p_realizado_por' => $validated['realizado_por'],
            'p_cod_usuario'   => $validated['cod_usuario'],
        ]);

        return $resp->successful()
            ? redirect()->route('backups.index')->with('success', 'Backup actualizado correctamente.')
            : redirect()->back()->with('error', 'Error al actualizar backup: '.$resp->body());
    }
}

