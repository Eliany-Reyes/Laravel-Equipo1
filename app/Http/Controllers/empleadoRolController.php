<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;

class EmpleadoRolController extends Controller
{
    // Define la URL base de la API externa.
    private string $api = 'http://localhost:3000';

    /**
     * Muestra una lista de asignaciones de empleados y roles obtenida de la API externa.
     * Renombrado de GetEmpleadosRoles a index para seguir la convención de Laravel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $response = Http::get("{$this->api}/empleadorol/obtenertodos");
        $rows = $response->json();

        // Normalización de la respuesta de la API:
        if (!is_array($rows)) {
            $rows = json_decode($response->body(), true) ?? [];
        }
        if (isset($rows['data']) && is_array($rows['data'])) {
            $rows = $rows['data'];
        }
        // Filtra para asegurar que solo se procesen arrays (útil si la API devuelve datos mixtos)
        $empleados_roles = array_values(array_filter($rows, 'is_array'));

        return view('personas.empleados_roles', compact('empleados_roles'));
    }

    /**
     * Almacena una nueva asignación de empleado-rol enviando los datos a la API externa.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los datos.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_empleado' => 'required|integer|min:1',
            'cod_rol'      => 'required|integer|min:1',
        ]);

        // Prepara el payload con los nombres de parámetros que espera tu API Node.
        // Se envían con y sin prefijo 'p_' para mayor compatibilidad con la API.
        $payload = [
            'p_cod_empleado' => (int)$validated['cod_empleado'],
            'cod_empleado'   => (int)$validated['cod_empleado'],
            'p_cod_rol'      => (int)$validated['cod_rol'],
            'cod_rol'        => (int)$validated['cod_rol'],
        ];

        $response = Http::post("{$this->api}/empleadorol/insertarempleadorol", $payload);

        $body = $response->json();
        if (!is_array($body)) {
            $body = json_decode($response->body(), true);
        }

        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al registrar: '.$response->body())->withInput();
        }
        $msg = strtolower($body['mensaje'] ?? '');
        if ($msg && !str_contains($msg, 'éxito') && !str_contains($msg, 'exito') && !str_contains($msg, 'success')) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        return redirect()->route('empleadorol.index')->with('success', 'Rol asignado correctamente.');
    }

    /**
     * Actualiza una asignación de empleado-rol existente.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP con los datos actualizados.
     * @param string $cod_empleado El ID del empleado cuya asignación de rol se va a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $cod_empleado): RedirectResponse
    {
        $validated = $request->validate([
            'cod_rol' => 'required|integer|min:1',
            // No se valida cod_empleado aquí porque se obtiene de la URL para identificar el registro.
        ]);

        $payload = [
            'p_cod_empleado' => (int)$cod_empleado,
            'cod_empleado'   => (int)$cod_empleado, // Asegurarse de que el ID del empleado se envíe correctamente.
            'p_cod_rol'      => (int)$validated['cod_rol'],
            'cod_rol'        => (int)$validated['cod_rol'],
        ];

        $response = Http::put("{$this->api}/empleadorol/actualizarempleadorol", $payload);

        $body = $response->json();
        if (!is_array($body)) {
            $body = json_decode($response->body(), true);
        }

        if (!$response->successful()) {
            return back()->with('error', 'Error HTTP al actualizar: '.$response->body())->withInput();
        }
        $msg = strtolower($body['mensaje'] ?? '');
        if ($msg && !str_contains($msg, 'éxito') && !str_contains($msg, 'exito') && !str_contains($msg, 'success')) {
            return back()->with('error', $body['mensaje'])->withInput();
        }

        return redirect()->route('empleadorol.index')->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Elimina una asignación de empleado-rol.
     *
     * @param string $cod_empleado El ID del empleado cuya asignación de rol se va a eliminar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($cod_empleado): RedirectResponse
    {
        // Asegúrate de que esta URL de API exista y sea correcta para eliminar.
        $response = Http::delete("{$this->api}/empleadorol/{$cod_empleado}");

        if ($response->successful()) {
            return redirect()->route('empleadorol.index')->with('success', 'Asignación eliminada correctamente.');
        }
        return redirect()->route('empleadorol.index')->with('error', 'Error al eliminar: '.$response->body());
    }
}