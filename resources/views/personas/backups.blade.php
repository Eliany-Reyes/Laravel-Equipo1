@extends('adminlte::page')

@section('title', 'Backups')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Listado de Backups</h1>
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
    <div class="alert alert-danger">{!! nl2br(e(session('error'))) !!}</div>
  @endif

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Listado de Backups</h3>
      <button class="btn btn-primary btn-sm"
              data-toggle="modal"
              data-target="#modalCrearBackup"
              onclick="resetCrearBackup()">
        <i class="fas fa-plus"></i> Nuevo backup
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-backups" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Cod Backup</th>
            <th>Fecha Backup</th>
            <th>Ruta Archivo</th>
            <th>Descripción</th>
            <th>Realizado Por</th>
            <th>Cod Usuario</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($backups as $backup)
          @php $b = (array) $backup; @endphp
          <tr>
            <td>{{ $b['cod_Backup'] ?? $b['cod_backup'] ?? '' }}</td>
            <td>{{ $b['fecha_backup'] ?? '' }}</td>
            <td>{{ $b['ruta_archivo'] ?? '' }}</td>
            <td>{{ $b['descripcion'] ?? '' }}</td>
            <td>{{ $b['realizado_por'] ?? '' }}</td>
            <td>{{ $b['cod_usuario'] ?? '' }}</td>
            <td>
              <button class="btn btn-warning btn-sm"
                      onclick="editarBackup(this)"
                      data-id="{{ $b['cod_Backup'] ?? $b['cod_backup'] ?? '' }}"
                      data-fecha="{{ $b['fecha_backup'] ?? '' }}"
                      data-ruta="{{ $b['ruta_archivo'] ?? '' }}"
                      data-descripcion="{{ $b['descripcion'] ?? '' }}"
                      data-realizado="{{ $b['realizado_por'] ?? '' }}"
                      data-usuario="{{ $b['cod_usuario'] ?? '' }}">
                Editar
              </button>
            </td>
          </tr>
        @empty
          <tr><td colspan="7" class="text-center">No hay backups registrados.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearBackup" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('backups.store') }}" id="formCrearBackup">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nuevo backup</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <label class="form-label">Fecha Backup</label>
              <input type="datetime-local" name="fecha_backup" class="form-control" required>
            </div>
            <div class="col-md-8">
              <label class="form-label">Ruta Archivo</label>
              <input type="text" name="ruta_archivo" class="form-control" maxlength="255" required>
            </div>
            <div class="col-md-12 mt-2">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" class="form-control"></textarea>
            </div>
            <div class="col-md-6 mt-2">
              <label class="form-label">Realizado Por</label>
              <input type="text" name="realizado_por" class="form-control" maxlength="100" required>
            </div>
            <div class="col-md-6 mt-2">
              <label class="form-label">Código Usuario</label>
              <input type="number" name="cod_usuario" class="form-control" min="1" required>
            </div>
          </div>
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
<div class="modal fade" id="modalEditarBackup" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarBackup" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar backup</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4">
              <label class="form-label">Fecha Backup</label>
              <input type="datetime-local" id="edit_fecha_backup" name="fecha_backup" class="form-control" required>
            </div>
            <div class="col-md-8">
              <label class="form-label">Ruta Archivo</label>
              <input type="text" id="edit_ruta_archivo" name="ruta_archivo" class="form-control" maxlength="255" required>
            </div>
            <div class="col-md-12 mt-2">
              <label class="form-label">Descripción</label>
              <textarea id="edit_descripcion" name="descripcion" class="form-control"></textarea>
            </div>
            <div class="col-md-6 mt-2">
              <label class="form-label">Realizado Por</label>
              <input type="text" id="edit_realizado_por" name="realizado_por" class="form-control" maxlength="100" required>
            </div>
            <div class="col-md-6 mt-2">
              <label class="form-label">Código Usuario</label>
              <input type="number" id="edit_cod_usuario" name="cod_usuario" class="form-control" min="1" required>
            </div>
          </div>
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
  $(function(){ $('#tabla-backups').DataTable(); });

  function resetCrearBackup(){
    const f = document.getElementById('formCrearBackup');
    if (f) f.reset();
  }

  function toLocal(s){
    if(!s) return '';
    let v = String(s).replace(' ','T').replace('Z','');
    return (v.split('.')[0] || v);
  }

  function editarBackup(btn){
    const d = btn.dataset;
    const form = document.getElementById('formEditarBackup');
    form.action = `/backup/${d.id}/actualizar`;

    document.getElementById('edit_fecha_backup').value  = toLocal(d.fecha);
    document.getElementById('edit_ruta_archivo').value  = d.ruta || '';
    document.getElementById('edit_descripcion').value   = d.descripcion || '';
    document.getElementById('edit_realizado_por').value = d.realizado || '';
    document.getElementById('edit_cod_usuario').value   = d.usuario || '';

    $('#modalEditarBackup').modal('show');
  }
</script>
@stop
