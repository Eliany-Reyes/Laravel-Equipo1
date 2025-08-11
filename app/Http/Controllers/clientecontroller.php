<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class ClienteController extends Controller
{
    public function index()
    {
        // Trae todo con el SP
        $rows = DB::select('CALL SEL_CLIENTES()');
        // Normaliza a array asociativo para Blade
        $clientes = array_map('get_object_vars', $rows);

        return view('personas.clientes', compact('clientes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'cod_persona'   => 'required|integer',
            'fecha_registro'=> 'required|date',
            'tipo_cliente'  => 'required|in:Visitante,Turista,Institucional',
            'motivo_visita' => 'required|string|max:100',
        ]);

        // Inserción directa (si tienes un INS_CLIENTE usa el CALL en su lugar)
        DB::insert(
            'INSERT INTO Clientes (cod_persona, fecha_registro, tipo_cliente, motivo_visita) VALUES (?,?,?,?)',
            [$data['cod_persona'], $data['fecha_registro'], $data['tipo_cliente'], $data['motivo_visita']]
        );

        return redirect()->route('clientes.index')->with('success', 'Cliente creado correctamente.');
    }

    public function update(Request $request, $cod_cliente): RedirectResponse
    {
        $data = $request->validate([
            'cod_persona'   => 'required|integer',
            'fecha_registro'=> 'required|date',
            'tipo_cliente'  => 'required|in:Visitante,Turista,Institucional',
            'motivo_visita' => 'required|string|max:100',
        ]);

        DB::update(
            'UPDATE Clientes SET cod_persona=?, fecha_registro=?, tipo_cliente=?, motivo_visita=? WHERE cod_cliente=?',
            [$data['cod_persona'], $data['fecha_registro'], $data['tipo_cliente'], $data['motivo_visita'], $cod_cliente]
        );

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($cod_cliente): RedirectResponse
    {
        DB::delete('DELETE FROM Clientes WHERE cod_cliente=?', [$cod_cliente]);
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado.');
    }
}

