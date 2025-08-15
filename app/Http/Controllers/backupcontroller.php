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
            $backups = [];
        }

        return view('personas.backups', compact('backups'));
    }

    // POST /backup/guardar
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha_backup'  => 'required|date_format:Y-m-d\TH:i',
            'ruta_archivo'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'realizado_por' => 'required|string|max:100',
            'cod_usuario'   => 'required|integer|min:1',
        ]);

        // Formato para MySQL
        $validated['fecha_backup'] = str_replace('T', ' ', $validated['fecha_backup']) . ':00';

        $resp = Http::post('http://localhost:3000/backup/InsertarBackup', $validated);

        if ($resp->failed()) {
            return redirect()->back()->with('error', 'Error al crear backup: '.$resp->body());
        }

        return redirect()->route('backups.index')->with('success', 'Backup creado correctamente.');
    }

    // PUT /backup/{cod_backup}/actualizar
    public function update(Request $request, $cod_backup)
    {
        $validated = $request->validate([
            'ruta_archivo'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'realizado_por' => 'required|string|max:100',
        ]);

        // El backend espera el ID en el body
        $data = array_merge(['cod_backup' => $cod_backup], $validated);

        $resp = Http::put('http://localhost:3000/backup/ActualizarBackup', $data);

        if ($resp->failed()) {
            return redirect()->back()->with('error', 'Error al actualizar backup: '.$resp->body());
        }

        return redirect()->route('backups.index')->with('success', 'Backup actualizado correctamente.');
    }

    // DELETE /backup/{cod_backup}
    public function destroy($cod_backup)
    {
        // El backend espera el ID en el body
        $resp = Http::withBody(json_encode(['cod_backup' => $cod_backup]), 'application/json')
                    ->delete('http://localhost:3000/backup/EliminarBackup');

        if ($resp->failed()) {
            return redirect()->back()->with('error', 'Error al eliminar backup: '.$resp->body());
        }

        return redirect()->route('backups.index')->with('success', 'Backup eliminado correctamente.');
    }
}
