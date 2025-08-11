@extends('adminlte::page')

@section('title', 'Empleados-Roles')

@section('content_header')
 
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Empleados-Roles</h1>
    <a href="{{ url('/home') }}" class="btn btn-secondary">
        <i class="fas fa-home"></i> Regresar al Home
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
      <h3 class="card-title">Listado</h3>
      <button class="btn btn-primary btn-sm"
              data-toggle="modal"
              data-target="#modalCrearER"
              onclick="resetCrearER()">
        <i class="fas fa-plus"></i> Asignar Rol
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-empleados-roles" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Empleado</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($empleados_roles as $er)
          <tr>
            <td>{{ $er['nombre_empleado'] ?? $er['cod_empleado'] ?? '' }}</td>
            <td>{{ $er['nombre_rol'] ?? $er['cod_rol'] ?? '' }}</td>
            <td class="text-nowrap">
              <button class="btn btn-warning btn-sm"
                      onclick="editarER(this)"
                      data-id="{{ $er['cod_empleado'] ?? '' }}"
                      data-rol="{{ $er['cod_rol'] ?? '' }}">
                Editar
              </button>

              {{-- Botón y formulario para eliminar (ACTIVO) --}}
              <form action="{{ route('empleadorol.destroy', $er['cod_empleado'] ?? 0) }}"
                    method="POST" style="display:inline-block;"
                    onsubmit="return confirm('¿Eliminar asignación de rol? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" class="text-center">No hay asignaciones registradas.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearER" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('empleadorol.store') }}" id="formCrearER">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Asignar rol a empleado</h5>
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
            <div class="col-md-6">
              <label class="form-label">Empleado (ID)</label>
              <input type="number" name="cod_empleado" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol (ID)</label>
              <input type="number" name="cod_rol" class="form-control" required>
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
<div class="modal fade" id="modalEditarER" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarER" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar rol de empleado</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Empleado (ID)</label>
              <input type="number" id="edit_cod_empleado" class="form-control" disabled>
            </div>
            <div class="col-md-6">
              <label class="form-label">Rol (ID)</label>
              <input type="number" name="cod_rol" id="edit_cod_rol" class="form-control" required>
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
  $(function(){ $('#tabla-empleados-roles').DataTable(); });

  function resetCrearER() {
    const f = document.getElementById('formCrearER');
    if (f) f.reset();
  }

  function editarER(btn) {
    const d = btn.dataset;
    const form = document.getElementById('formEditarER');
    // La acción de PUT necesita el ID del empleado
    form.action = `/empleados_roles/${d.id}/actualizar`;

    document.getElementById('edit_cod_empleado').value = d.id || '';
    document.getElementById('edit_cod_rol').value      = d.rol || '';

    $('#modalEditarER').modal('show');
  }
</script>
@stop