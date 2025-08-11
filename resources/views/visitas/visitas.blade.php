
@extends('adminlte::page')

@section('title', 'Visitas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Visitas</h1>
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
      <h3 class="card-title">Listado de Visitas</h3>
     <button class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#modalCrearVisita"
        onclick="resetCrearVisita()">
        <i class="fas fa-plus"></i> Agregar Visita

      </button>
    </div>

    <div class="card-body">
      <table id="tabla-visitas" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Persona</th>
            <th>Fecha Entrada</th>
            <th>Hora Salida</th>
            <th>Motivo</th>
            <th>Adultos</th>
            <th>Niños</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($visitas as $v)
            <tr>
              <td>{{ $v['cod_visita'] }}</td>
              <td>{{ $v['nombre_persona'] ?? $v['cod_persona'] }}</td>
              <td>{{ $v['fecha_entrada'] }}</td>
              <td>{{ $v['hora_salida'] ?? 'Pendiente' }}</td>
              <td>{{ $v['motivo_visita'] }}</td>
              <td>{{ $v['cantidad_adultos'] }}</td>
              <td>{{ $v['cantidad_ninos'] }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm"
                          onclick="editarVisita(this)"
                          data-id="{{ $v['cod_visita'] }}"
                          data-hora-salida="{{ $v['hora_salida'] ?? '' }}"
                          data-motivo="{{ $v['motivo_visita'] ?? '' }}"
                          data-observaciones="{{ $v['observaciones'] ?? '' }}"
                          data-adultos="{{ $v['cantidad_adultos'] ?? 0 }}"
                          data-ninos="{{ $v['cantidad_ninos'] ?? 0 }}"
                          data-precio-adulto="{{ $v['precio_entrada_adulto'] ?? 0 }}"
                          data-precio-nino="{{ $v['precio_entrada_nino'] ?? 0 }}">
                          Editar
                          </button>

    <form action="{{ route('visitas.destroy', $v['cod_visita']) }}" method="POST" style="display:inline-block;" 
          onsubmit="return confirm('¿Seguro que deseas eliminar esta visita?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            Eliminar
        </button>
    </form>
</td>
            </tr>
          @endforeach

          @if(empty($visitas) || count($visitas) === 0)
            <tr><td colspan="8" class="text-center">No hay visitas registradas.</td></tr>
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearVisita" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('visitas.store') }}" id="formCrearVisita">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar nueva visita</h5>
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
            <div class="col-md-4">
              <label class="form-label">Persona (ID)</label>
              <input type="number" name="cod_persona" class="form-control" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Hora Salida</label>
              <input type="datetime-local" name="hora_salida" class="form-control">
            </div>
            <div class="col-md-4">
              <label class="form-label">Motivo</label>
              <input type="text" name="motivo_visita" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">Observaciones</label>
              <input type="text" name="observaciones" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label">Adultos</label>
              <input type="number" name="cantidad_adultos" class="form-control" value="0" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Niños</label>
              <input type="number" name="cantidad_ninos" class="form-control" value="0" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Precio Adulto</label>
              <input type="number" step="0.01" name="precio_entrada_adulto" class="form-control" value="0">
            </div>
            <div class="col-md-3">
              <label class="form-label">Precio Niño</label>
              <input type="number" step="0.01" name="precio_entrada_nino" class="form-control" value="0">
            </div>

            <div class="col-md-6">
              <label class="form-label">Código Bosque</label>
              <input type="number" name="cod_bosque" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Código Acceso</label>
              <input type="number" name="cod_acceso" class="form-control" required>
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
<div class="modal fade" id="modalEditarVisita" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formEditarVisita" method="POST">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Editar visita</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Hora Salida</label>
              <input type="datetime-local" name="hora_salida" id="edit_hora_salida" class="form-control">
            </div>
            <div class="col-md-6">
              <label class="form-label">Motivo</label>
              <input type="text" name="motivo_visita" id="edit_motivo_visita" class="form-control" required>
            </div>

            <div class="col-md-12">
              <label class="form-label">Observaciones</label>
              <input type="text" name="observaciones" id="edit_observaciones" class="form-control">
            </div>

            <div class="col-md-3">
              <label class="form-label">Adultos</label>
              <input type="number" name="cantidad_adultos" id="edit_cantidad_adultos" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Niños</label>
              <input type="number" name="cantidad_ninos" id="edit_cantidad_ninos" class="form-control" required>
            </div>
            <div class="col-md-3">
              <label class="form-label">Precio Adulto</label>
              <input type="number" step="0.01" name="precio_entrada_adulto" id="edit_precio_entrada_adulto" class="form-control">
            </div>
            <div class="col-md-3">
              <label class="form-label">Precio Niño</label>
              <input type="number" step="0.01" name="precio_entrada_nino" id="edit_precio_entrada_nino" class="form-control">
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
  $(function(){ $('#tabla-visitas').DataTable(); });

  function resetCrearVisita() {
    const f = document.getElementById('formCrearVisita');
    if (f) f.reset();
  }

  function editarVisita(btn) {
    const d = btn.dataset;
    const form = document.getElementById('formEditarVisita');
    form.action = `/visitas/${d.id}/actualizar`;

    const toDatetimeLocal = (s) => {
      if (!s) return '';
      let v = s.replace(' ', 'T');
      v = v.replace('Z','');
      v = v.split('.')[0] || v;
      return v;
    };

    document.getElementById('edit_hora_salida').value = toDatetimeLocal(d.horaSalida);
    document.getElementById('edit_motivo_visita').value = d.motivo || '';
    document.getElementById('edit_observaciones').value = d.observaciones || '';
    document.getElementById('edit_cantidad_adultos').value = d.adultos ?? 0;
    document.getElementById('edit_cantidad_ninos').value = d.ninos ?? 0;
    document.getElementById('edit_precio_entrada_adulto').value = d.precioAdulto ?? 0;
    document.getElementById('edit_precio_entrada_nino').value = d.precioNino ?? 0;

    $('#modalEditarVisita').modal('show');
  }
</script>
@if(request('crear'))
<script>
  $(function () { $('#modalCrearVisita').modal('show'); });
</script>
@endif
@stop
