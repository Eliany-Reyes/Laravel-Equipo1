@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Clientes</h1>
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
      <h3 class="card-title mb-0">Listado de Clientes</h3>
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearCliente" onclick="resetCrearCliente()">
        <i class="fas fa-plus"></i> Agregar Cliente
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-clientes" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Cod Cliente</th>
            <th>Cod Persona</th>
            <th>Fecha Registro</th>
            <th>Tipo Cliente</th>
            <th>Motivo Visita</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        @forelse($clientes as $c)
          <tr>
            <td>{{ $c['cod_Cliente'] ?? $c['cod_cliente'] }}</td>
            <td>{{ $c['cod_persona'] }}</td>
            <td>{{ $c['fecha_registro'] }}</td>
            <td>{{ $c['tipo_cliente'] }}</td>
            <td>{{ $c['motivo_visita'] }}</td>
            <td class="text-nowrap">
              <button class="btn btn-warning btn-sm"
                onclick="editarCliente(this)"
                data-id="{{ $c['cod_Cliente'] ?? $c['cod_cliente'] }}"
                data-cod-persona="{{ $c['cod_persona'] }}"
                data-fecha="{{ $c['fecha_registro'] }}"
                data-tipo="{{ $c['tipo_cliente'] }}"
                data-motivo="{{ $c['motivo_visita'] }}">
                Editar
              </button>

              <form action="{{ route('clientes.destroy', $c['cod_Cliente'] ?? $c['cod_cliente']) }}"
                    method="POST" style="display:inline-block;"
                    onsubmit="return confirm('¿Eliminar este cliente?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center">No hay clientes registrados.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('clientes.store') }}" id="formCrearCliente">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nuevo cliente</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Cod Persona</label>
            <input type="number" name="cod_persona" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Fecha Registro</label>
            <input type="date" name="fecha_registro" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Tipo Cliente</label>
            <select name="tipo_cliente" class="form-control" required>
              <option value="Visitante">Visitante</option>
              <option value="Turista">Turista</option>
              <option value="Institucional">Institucional</option>
            </select>
          </div>
          <div class="form-group">
            <label>Motivo Visita</label>
            <input type="text" name="motivo_visita" class="form-control" maxlength="100" required>
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
<div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="formEditarCliente" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar cliente</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Cod Persona</label>
            <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Fecha Registro</label>
            <input type="date" name="fecha_registro" id="edit_fecha_registro" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Tipo Cliente</label>
            <select name="tipo_cliente" id="edit_tipo_cliente" class="form-control" required>
              <option value="Visitante">Visitante</option>
              <option value="Turista">Turista</option>
              <option value="Institucional">Institucional</option>
            </select>
          </div>
          <div class="form-group">
            <label>Motivo Visita</label>
            <input type="text" name="motivo_visita" id="edit_motivo_visita" class="form-control" maxlength="100" required>
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
  $(function(){ $('#tabla-clientes').DataTable(); });

  function resetCrearCliente(){ document.getElementById('formCrearCliente').reset(); }

  function editarCliente(btn){
    const d = btn.dataset;
    const f = document.getElementById('formEditarCliente');
    f.action = `/clientes/${d.id}/actualizar`;

    // Normalizar fecha a input[type=date]
    const toDate = (s) => (s || '').split('T')[0] || s;

    document.getElementById('edit_cod_persona').value   = d.codPersona || d.codPersona === 0 ? d.codPersona : d.codPersona;
    document.getElementById('edit_fecha_registro').value= toDate(d.fecha);
    document.getElementById('edit_tipo_cliente').value  = d.tipo || 'Visitante';
    document.getElementById('edit_motivo_visita').value = d.motivo || '';
    $('#modalEditarCliente').modal('show');
  }
</script>
@stop
