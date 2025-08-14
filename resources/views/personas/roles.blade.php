@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Roles</h1>
    <a href="{{ route('home') }}" class="btn btn-secondary">
      <i class="fas fa-home"></i> Volver al Home
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
      <h3 class="card-title mb-0">Listado de Roles</h3>
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearRol" onclick="resetCrearRol()">
        <i class="fas fa-plus"></i> Agregar Rol
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-roles" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Cod Rol</th>
            <th>Nombre Rol</th>
            <th>Descripción</th>
            <th>Nivel Acceso</th>
            <th>Permisos</th>
            <th>Creado Por</th>
            <th>Activo</th>
            <th>Observaciones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($roles as $r)
          <tr>
            <td>{{ $r['cod_rol'] ?? '' }}</td>
            <td>{{ $r['nombre_rol'] ?? '' }}</td>
            <td>{{ $r['descripcion'] ?? '' }}</td>
            <td>{{ $r['nivel_acceso'] ?? '' }}</td>
            <td>{{ $r['permisos'] ?? '' }}</td>
            <td>{{ $r['creados_por'] ?? '' }}</td>
            <td>{{ isset($r['activo']) ? ($r['activo'] ? 'Sí' : 'No') : '' }}</td>
            <td>{{ $r['observaciones'] ?? '' }}</td>
            <td class="text-nowrap">
              <button class="btn btn-warning btn-sm"
                onclick="editarRol(this)"
                data-id="{{ $r['cod_rol'] ?? '' }}"
                data-nombre="{{ $r['nombre_rol'] ?? '' }}"
                data-desc="{{ $r['descripcion'] ?? '' }}"
                data-nivel="{{ $r['nivel_acceso'] ?? '' }}"
                data-permisos="{{ $r['permisos'] ?? '' }}"
                data-creado="{{ $r['creados_por'] ?? '' }}"
                data-activo="{{ $r['activo'] ?? 0 }}"
                data-observaciones="{{ $r['observaciones'] ?? '' }}">
                Editar
              </button>

              <form action="{{ route('roles.destroy', $r['cod_rol'] ?? 0) }}"
                    method="POST" style="display:inline-block;"
                    onsubmit="return confirm('¿Eliminar este rol?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="9" class="text-center">No hay roles registrados.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearRol" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('roles.store') }}" id="formCrearRol">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nuevo rol</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Nombre Rol</label><input type="text" name="nombre_rol" class="form-control" required></div>
          <div class="form-group"><label>Descripción</label><input type="text" name="descripcion" class="form-control"></div>
          <div class="form-group"><label>Nivel Acceso</label><input type="number" name="nivel_acceso" class="form-control" required></div>
          <div class="form-group"><label>Permisos</label><input type="text" name="permisos" class="form-control"></div>
          <div class="form-group"><label>Creado Por</label><input type="text" name="creados_por" class="form-control"></div>
          <div class="form-group"><label>Activo</label>
            <select name="activo" class="form-control">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group"><label>Observaciones</label><textarea name="observaciones" class="form-control"></textarea></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" type="submit">Guardar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditarRol" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarRol" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar rol</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Nombre Rol</label><input type="text" name="nombre_rol" id="edit_nombre_rol" class="form-control" required></div>
          <div class="form-group"><label>Descripción</label><input type="text" name="descripcion" id="edit_descripcion" class="form-control"></div>
          <div class="form-group"><label>Nivel Acceso</label><input type="number" name="nivel_acceso" id="edit_nivel_acceso" class="form-control" required></div>
          <div class="form-group"><label>Permisos</label><input type="text" name="permisos" id="edit_permisos" class="form-control"></div>
          <div class="form-group"><label>Creado Por</label><input type="text" name="creados_por" id="edit_creados_por" class="form-control"></div>
          <div class="form-group"><label>Activo</label>
            <select name="activo" id="edit_activo" class="form-control">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="form-group"><label>Observaciones</label><textarea name="observaciones" id="edit_observaciones" class="form-control"></textarea></div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="submit">Actualizar</button>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>
@stop

@section('js')
<script>
  $(function(){ $('#tabla-roles').DataTable(); });

  function resetCrearRol(){ document.getElementById('formCrearRol').reset(); }

  function editarRol(btn){
    const d = btn.dataset;
    const f = document.getElementById('formEditarRol');
    f.action = `/roles/${d.id}/actualizar`;

    document.getElementById('edit_nombre_rol').value = d.nombre || '';
    document.getElementById('edit_descripcion').value = d.desc || '';
    document.getElementById('edit_nivel_acceso').value = d.nivel || '';
    document.getElementById('edit_permisos').value = d.permisos || '';
    document.getElementById('edit_creados_por').value = d.creado || '';
    document.getElementById('edit_activo').value = d.activo || '0';
    document.getElementById('edit_observaciones').value = d.observaciones || '';

    $('#modalEditarRol').modal('show');
  }
</script>
@stop
