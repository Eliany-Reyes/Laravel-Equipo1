
@extends('adminlte::page')

@section('title', 'Pantallas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Pantallas</h1>
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

  {{-- LISTADO --}}
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h3 class="card-title">Listado de Pantallas</h3>
      <button class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#modalCrearPantalla"
        onclick="resetCrearPantalla()">
        <i class="fas fa-plus"></i> Agregar Pantalla
      </button>
    </div>

    <div class="card-body">
      <table id="tabla-pantallas" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Codigo Pantallas</th>
            <th>Nombre Pantalla</th>
            <th>Ruta URL</th>
            <th>Descripción</th>
            <th>Modulo</th>
            <th>Icono</th>
            <th>Orden Menu</th>
            <th>Visible Menu</th>
            <th>Fecha Creacion</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          @forelse($pantallas as $p)
            <tr>
              <td>{{ is_array($p) ? $p['cod_Pantalla'] : $p->cod_Pantalla }}</td>
              <td>{{ is_array($p) ? $p['nombre_pantalla'] : $p->nombre_pantalla }}</td>
              <td>{{ is_array($p) ? $p['ruta_url'] : $p->ruta_url }}</td>
              <td>{{ is_array($p) ? ($p['descripcion'] ?? 'Sin descripción') : ($p->descripcion ?? 'Sin descripción') }}</td>
              <td>{{ is_array($p) ? $p['modulo'] : $p->modulo }}</td>
              <td>{{ is_array($p) ? $p['icono'] : $p->icono }}</td>
              <td>{{ is_array($p) ? $p['orden_menu'] : $p->orden_menu }}</td>
              <td>{{ is_array($p) ? $p['visible_menu'] : $p->visible_menu }}</td>
              <td>{{ is_array($p) ? $p['fecha_creacion'] : $p->fecha_creacion }}</td>
              <td>{{ is_array($p) ? $p['estado'] : $p->estado }}</td>

              <td>
               <button class="btn btn-warning btn-sm"
                  onclick="editarPantalla(this)"
                  data-id="{{ is_array($p) ? $p['cod_Pantalla'] : $p->cod_Pantalla }}"
                  data-nombre="{{ is_array($p) ? $p['nombre_pantalla'] : $p->nombre_pantalla }}"
                  data-descripcion="{{ is_array($p) ? ($p['descripcion'] ?? '') : ($p->descripcion ?? '') }}"
                  data-ruta="{{ is_array($p) ? $p['ruta_url'] : $p->ruta_url }}"
                  data-modulo="{{ is_array($p) ? $p['modulo'] : $p->modulo }}"
                  data-icono="{{ is_array($p) ? $p['icono'] : $p->icono }}"
                  data-orden="{{ is_array($p) ? $p['orden_menu'] : $p->orden_menu }}"
                  data-visible="{{ is_array($p) ? $p['visible_menu'] : $p->visible_menu }}"
                  data-fecha="{{ is_array($p) ? $p['fecha_creacion'] : $p->fecha_creacion }}"
                  data-estado="{{ is_array($p) ? $p['estado'] : $p->estado }}">
                  Editar
</button>

                <form action="{{ route('pantallas.destroy', is_array($p) ? $p['cod_Pantalla'] : $p->cod_Pantalla) }}" method="POST" style="display:inline-block;"
                      onsubmit="return confirm('¿Seguro que deseas eliminar esta pantalla?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center">No hay pantallas registradas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearPantalla" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('pantallas.store') }}" id="formCrearPantalla">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nueva pantalla</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre Pantalla</label>
              <input type="text" name="nombre_pantalla" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Ruta</label>
              <input type="text" name="ruta" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" class="form-control"></textarea>
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
<div class="modal fade" id="modalEditarPantalla" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarPantalla" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar pantalla</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Nombre Pantalla</label>
              <input type="text" name="nombre_pantalla" id="edit_nombre_pantalla" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Ruta</label>
              <input type="text" name="ruta" id="edit_ruta" class="form-control" required>
            </div>
            <div class="col-md-12">
              <label class="form-label">Descripción</label>
              <textarea name="descripcion" id="edit_descripcion" class="form-control"></textarea>
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
  $(function(){ $('#tabla-pantallas').DataTable(); });

  function resetCrearPantalla() {
    document.getElementById('formCrearPantalla').reset();
  }

  function editarPantalla(btn) {
    const d = btn.dataset;
    const form = document.getElementById('formEditarPantalla');
    form.action = /pantallas/${d.id}/actualizar;

    document.getElementById('edit_nombre_pantalla').value = d.nombre || '';
    document.getElementById('edit_descripcion').value = d.descripcion || '';
    document.getElementById('edit_ruta').value = d.ruta || '';

    $('#modalEditarPantalla').modal('show');
  }
</script>
@stop