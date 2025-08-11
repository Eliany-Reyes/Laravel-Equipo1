<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function index(): View
    {
        $rows = DB::select('CALL SEL_LOGIN()');       // SP: SELECT * FROM Logins
        $logins = array_map('get_object_vars', $rows); // normaliza a array
        return view('personas.logins', compact('logins'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'fecha_login' => 'required|date',
            'ip_usuario'  => 'nullable|string|max:45',
            'navegador'   => 'nullable|string|max:100',
            'exito_login' => 'required|boolean',
            'cod_usuario' => 'required|integer',
        ]);

        // Inserción directa (si tienes INS_LOGIN usa CALL INS_LOGIN(?,?,?,?,?) en su lugar)
        DB::insert(
            'INSERT INTO Logins (fecha_login, ip_usuario, navegador, exito_login, cod_usuario) VALUES (?,?,?,?,?)',
            [
                date('Y-m-d H:i:s', strtotime($data['fecha_login'])),
                $data['ip_usuario'] ?? '',
                $data['navegador'] ?? '',
                $data['exito_login'],
                $data['cod_usuario'],
            ]
        );

        return redirect()->route('logins.index')->with('success', 'Login registrado correctamente.');
    }

    public function destroy($cod_Login): RedirectResponse
    {
        DB::delete('DELETE FROM Logins WHERE cod_Login = ?', [$cod_Login]);
        return redirect()->route('logins.index')->with('success', 'Login eliminado correctamente.');
    }
}
