@extends('adminlte::page')

@section('title', 'Direcciones')

@section('content_header')
 
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Direcciones</h1>
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
      <h3 class="card-title">Listado de Direcciones</h3>
      <button class="btn btn-primary btn-sm"
              data-toggle="modal"
              data-target="#modalCrearDireccion"
              onclick="resetCrearDireccion()">
        <i class="fas fa-plus"></i> Agregar Dirección
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-direcciones" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Persona</th>
            <th>Hogar</th>
            <th>Ciudad</th>
            <th>Departamento</th>
            <th>Colonia</th>
            <th>Código Postal</th>
            <th>Trabajo</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @foreach($direcciones as $d)
  <tr>
    <td>{{ $d['cod_direcciones'] ?? '' }}</td>
    <td>{{ $d['nombre_persona'] ?? $d['cod_persona'] ?? '' }}</td>
    <td>{{ $d['Direccion_hogar'] ?? $d['direccion_hogar'] ?? '' }}</td>
    <td>{{ $d['Ciudad'] ?? $d['ciudad'] ?? '' }}</td>
    <td>{{ $d['Departamento'] ?? $d['departamento'] ?? '' }}</td>
    <td>{{ $d['Colonia'] ?? $d['colonia'] ?? '' }}</td>
    <td>{{ $d['Codigo_postal'] ?? $d['codigo_postal'] ?? '' }}</td>
    <td>{{ $d['Direccion_trabajo'] ?? $d['direccion_trabajo'] ?? '' }}</td>
    <td class="text-nowrap">
      {{-- Botón editar --}}
      <button class="btn btn-warning btn-sm"
              onclick="editarDireccion(this)"
              data-id="{{ $d['cod_direcciones'] ?? '' }}"
              data-cod-persona="{{ $d['cod_persona'] ?? '' }}"
              data-hogar="{{ $d['Direccion_hogar'] ?? $d['direccion_hogar'] ?? '' }}"
              data-ciudad="{{ $d['Ciudad'] ?? $d['ciudad'] ?? '' }}"
              data-departamento="{{ $d['Departamento'] ?? $d['departamento'] ?? '' }}"
              data-colonia="{{ $d['Colonia'] ?? $d['colonia'] ?? '' }}"
              data-postal="{{ $d['Codigo_postal'] ?? $d['codigo_postal'] ?? '' }}"
              data-trabajo="{{ $d['Direccion_trabajo'] ?? $d['direccion_trabajo'] ?? '' }}">
        Editar
      </button>

      {{-- Botón eliminar --}}
      <form action="{{ route('direcciones.destroy', $d['cod_direcciones'] ?? 0) }}"
            method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('¿Está seguro de eliminar esta dirección?')">
          Eliminar
        </button>
      </form>
    </td>
  </tr>
@endforeach


        @if(empty($direcciones) || count($direcciones) === 0)
          <tr><td colspan="9" class="text-center">No hay direcciones registradas.</td></tr>
        @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearDireccion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('direcciones.store') }}" id="formCrearDireccion">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nueva dirección</h5>
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
            <div class="col-md-9">
              <label class="form-label">Dirección hogar</label>
              <input type="text" name="direccion_hogar" class="form-control">
            </div>

            <div class="col-md-4">
              <label class="form-label">Ciudad</label>
              <input type="text" name="ciudad" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Departamento</label>
              <input type="text" name="departamento" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Colonia</label>
              <input type="text" name="colonia" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label">Código Postal</label>
              <input type="number" name="codigo_postal" class="form-control">
            </div>
            <div class="col-md-9">
              <label class="form-label">Dirección trabajo</label>
              <input type="text" name="direccion_trabajo" class="form-control">
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
<div class="modal fade" id="modalEditarDireccion" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarDireccion" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar dirección</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            {{-- Añadido campo oculto para el ID de la dirección --}}
            <input type="hidden" name="cod_direcciones" id="edit_cod_direcciones">

            <div class="col-md-3">
              <label class="form-label">Persona (ID)</label>
              <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
            </div>
            <div class="col-md-9">
              <label class="form-label">Dirección hogar</label>
              <input type="text" name="direccion_hogar" id="edit_direccion_hogar" class="form-control">
            </div>

            <div class="col-md-4">
              <label class="form-label">Ciudad</label>
              <input type="text" name="ciudad" id="edit_ciudad" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Departamento</label>
              <input type="text" name="departamento" id="edit_departamento" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Colonia</label>
              <input type="text" name="colonia" id="edit_colonia" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label">Código Postal</label>
              <input type="number" name="codigo_postal" id="edit_codigo_postal" class="form-control">
            </div>
            <div class="col-md-9">
              <label class="form-label">Dirección trabajo</label>
              <input type="text" name="direccion_trabajo" id="edit_direccion_trabajo" class="form-control">
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
  $(function(){ $('#tabla-direcciones').DataTable(); });

  function resetCrearDireccion() {
    const f = document.getElementById('formCrearDireccion');
    if (f) f.reset();
  }

  function editarDireccion(btn) {
    const d = btn.dataset;
    const form = document.getElementById('formEditarDireccion');
    form.action = `/direcciones/${d.id}/actualizar`;

    // Asigna el ID al campo oculto para que se envíe con el formulario
    document.getElementById('edit_cod_direcciones').value = d.id || '';

    document.getElementById('edit_cod_persona').value        = d.codPersona || '';
    document.getElementById('edit_direccion_hogar').value    = d.hogar || '';
    document.getElementById('edit_ciudad').value             = d.ciudad || '';
    document.getElementById('edit_departamento').value       = d.departamento || '';
    document.getElementById('edit_colonia').value            = d.colonia || '';
    document.getElementById('edit_codigo_postal').value      = d.postal || '';
    document.getElementById('edit_direccion_trabajo').value  = d.trabajo || '';

    $('#modalEditarDireccion').modal('show');
  }
</script>
@stop