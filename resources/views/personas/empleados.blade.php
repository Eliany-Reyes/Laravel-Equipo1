@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')

   <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Empleados</h1>
    <a href="{{ url('/personas-inicio') }}" class="btn btn-secondary">
        <i class="fas fa-home"></i> Regresar al menú de Personas
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Listado de Empleados</h3>
      <button class="btn btn-primary btn-sm"
              data-toggle="modal"
              data-target="#modalCrearEmpleado"
              onclick="resetCrearEmpleado()">
        <i class="fas fa-plus"></i> Agregar Empleado
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-empleados" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Persona</th>
            <th>Cargo</th>
            <th>Área Asignada</th>
            <th>Fecha Contratación</th>
            <th>Salario</th>
            <th>Estado</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @forelse($empleados as $e)
            <tr>
              <td>{{ $e['cod_empleado'] ?? '' }}</td>
              <td>{{ $e['nombre_persona'] ?? $e['cod_persona'] ?? '' }}</td>
              <td>{{ $e['cargo'] ?? '' }}</td>
              <td>{{ $e['area_asignada'] ?? '' }}</td>
              <td>{{ $e['fecha_contratacion'] ?? '' }}</td>
              <td>{{ $e['salario'] ?? '' }}</td>
              <td>{{ $e['estado'] ?? '' }}</td>
              <td class="text-nowrap">
                <button class="btn btn-warning btn-sm"
                        onclick="editarEmpleado(this)"
                        data-id="{{ $e['cod_empleado'] ?? '' }}"
                        data-cod-persona="{{ $e['cod_persona'] ?? '' }}"
                        data-cargo="{{ $e['cargo'] ?? '' }}"
                        data-area="{{ $e['area_asignada'] ?? '' }}"
                        data-fecha="{{ $e['fecha_contratacion'] ?? '' }}"
                        data-salario="{{ $e['salario'] ?? '' }}"
                        data-estado="{{ $e['estado'] ?? '' }}">
                  Editar
                </button>

                <form action="{{ route('empleados.destroy', $e['cod_empleado'] ?? 0) }}"
                    method="POST" style="display:inline-block;"
                    onsubmit="return confirm('¿Está seguro de que desea eliminar a este empleado? Esta acción no se puede deshacer.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="8" class="text-center">No hay empleados registrados.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearEmpleado" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('empleados.store') }}" id="formCrearEmpleado">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nuevo empleado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $e)
                  <li>{{ $e }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Persona (ID)</label>
              <input type="number" name="cod_persona" class="form-control" required>
            </div>

            <div class="col-md-3">
              <label class="form-label">Cargo</label>
              <select name="cargo" class="form-control" required>
                <option value="">-- Seleccione --</option>
                <option value="Guia">Guía</option>
                <option value="Guardabosque">Guardabosque</option>
                <option value="Administrador">Administrador</option>
                <option value="Recepcionista">Recepcionista</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Área asignada</label>
              <input type="text" name="area_asignada" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Fecha contratación</label>
              <input type="date" name="fecha_contratacion" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Salario</label>
              <input type="number" step="0.01" inputmode="decimal" name="salario" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Estado</label>
              <input type="text" name="estado" class="form-control" placeholder="Activo/Inactivo" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditarEmpleado" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarEmpleado" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar empleado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label">Persona (ID)</label>
              <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
            </div>

            <div class="col-md-3">
              <label class="form-label">Cargo</label>
              <select name="cargo" id="edit_cargo" class="form-control" required>
                <option value="Guia">Guía</option>
                <option value="Guardabosque">Guardabosque</option>
                <option value="Administrador">Administrador</option>
                <option value="Recepcionista">Recepcionista</option>
                <option value="Otro">Otro</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Área asignada</label>
              <input type="text" name="area_asignada" id="edit_area_asignada" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Fecha contratación</label>
              <input type="date" name="fecha_contratacion" id="edit_fecha_contratacion" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Salario</label>
              <input type="number" step="0.01" inputmode="decimal" name="salario" id="edit_salario" class="form-control" required>
            </div>

            <div class="col-md-4">
              <label class="form-label">Estado</label>
              <input type="text" name="estado" id="edit_estado" class="form-control" required>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@stop

@section('js')
<script>
  $(function(){ $('#tabla-empleados').DataTable(); });

  function resetCrearEmpleado() {
    const f = document.getElementById('formCrearEmpleado');
    if (f) f.reset();
  }

  function editarEmpleado(btn) {
    const d = btn.dataset;
    const form = document.getElementById('formEditarEmpleado');
    form.action = `/empleados/${d.id}/actualizar`;

    // normaliza fecha => yyyy-mm-dd
    let fecha = d.fecha || '';
    if (fecha.includes('T')) fecha = fecha.split('T')[0];
    if (fecha.includes(' ')) fecha = fecha.split(' ')[0];

    // normaliza salario => con punto decimal
    const salario = (d.salario || '').toString().replace(',', '.');

    document.getElementById('edit_cod_persona').value        = d.codPersona || '';
    document.getElementById('edit_cargo').value              = d.cargo || '';
    document.getElementById('edit_area_asignada').value      = d.area || '';
    document.getElementById('edit_fecha_contratacion').value = fecha || '';
    document.getElementById('edit_salario').value            = salario || '';
    document.getElementById('edit_estado').value             = d.estado || '';

    $('#modalEditarEmpleado').modal('show');
  }
</script>
@stop