<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmpleadoController extends Controller
{
    // Define la URL base de la API externa.
    private string $api = 'http://localhost:3000';

    /**
     * Muestra una lista de empleados obtenida de la API externa.
     * Renombrado de GetEmpleados a index para seguir la convención de Laravel.
     *
     * @return View
     */
    public function index(): View
    {
        $response = Http::get("{$this->api}/empleados/obtenertodos");
        $empleados = $response->json();
        
        // Normalización de la respuesta de la API:
        if (!is_array($empleados)) {
            $empleados = json_decode($response->body(), true) ?? [];
        }
        if (isset($empleados['data']) && is_array($empleados['data'])) {
            $empleados = $empleados['data'];
        }

        return view('personas.empleados', compact('empleados'));
    }

    /**
     * Almacena un nuevo empleado enviando los datos a la API externa.
     * Renombrado de StoreEmpleado a store para seguir la convención de Laravel.
     *
     * @param Request $request La solicitud HTTP que contiene los datos.
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'        => 'required|integer|min:1',
            'cargo'              => 'required|string|max:30',
            'area_asignada'      => 'required|string|max:100',
            'fecha_contratacion' => 'required|date',
            'salario'            => 'required|numeric|min:0',
            'estado'             => 'required|string|max:30',
        ]);

        $payload = [
            'p_cod_persona'        => (int)$validated['cod_persona'],
            'p_cargo'              => $validated['cargo'],
            'p_area_asignada'      => $validated['area_asignada'],
            'p_fecha_contratacion' => date('Y-m-d', strtotime($validated['fecha_contratacion'])),
            'p_salario'            => (float)$validated['salario'],
            'p_estado'             => $validated['estado'],
        ];

        $response = Http::post("{$this->api}/empleados/insertarempleado", $payload);
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

        return redirect()->route('empleados.index')->with('success', 'Empleado registrado correctamente.');
    }

    /**
     * Actualiza un empleado existente.
     * Renombrado de UpdateEmpleado a update para seguir la convención de Laravel.
     *
     * @param Request $request La solicitud HTTP con los datos actualizados.
     * @param string $cod_empleado El ID del empleado a actualizar.
     * @return RedirectResponse
     */
    public function update(Request $request, $cod_empleado): RedirectResponse
    {
        $validated = $request->validate([
            'cod_persona'        => 'required|integer|min:1',
            'cargo'              => 'required|string|max:30',
            'area_asignada'      => 'required|string|max:100',
            'fecha_contratacion' => 'required|date',
            'salario'            => 'required|numeric|min:0',
            'estado'             => 'required|string|max:30',
        ]);

        $payload = [
            'p_cod_empleado'         => (int)$cod_empleado,
            'cod_empleado'           => (int)$cod_empleado,
            'p_cod_persona'          => (int)$validated['cod_persona'],
            'cod_persona'            => (int)$validated['cod_persona'],
            'p_cargo'                => $validated['cargo'],
            'cargo'                  => $validated['cargo'],
            'p_area_asignada'        => $validated['area_asignada'],
            'area_asignada'          => $validated['area_asignada'],
            'p_fecha_contratacion'   => date('Y-m-d', strtotime($validated['fecha_contratacion'])),
            'fecha_contratacion'     => date('Y-m-d', strtotime($validated['fecha_contratacion'])),
            'p_salario'              => (float)$validated['salario'],
            'salario'                => (float)$validated['salario'],
            'p_estado'               => $validated['estado'],
            'estado'                 => $validated['estado'],
        ];

        $response = Http::put("{$this->api}/empleados/actualizarempleado", $payload);

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

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    /**
     * Elimina un empleado.
     *
     * @param string $cod_empleado El ID del empleado a eliminar.
     * @return RedirectResponse
     */
    public function destroy($cod_empleado): RedirectResponse
    {
        // Asegúrate de que esta URL de API exista y sea correcta para eliminar.
        $response = Http::delete("{$this->api}/empleados/{$cod_empleado}");

        if ($response->successful()) {
            return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
        }
        return redirect()->route('empleados.index')->with('error', 'Error al eliminar: '.$response->body());
    }
}