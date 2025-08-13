@extends('adminlte::page')

@section('title', 'Teléfonos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Teléfonos</h1>
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
            <h3 class="card-title mb-0">Listado de Teléfonos</h3>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearTelefono" onclick="resetCrearTelefono()">
                <i class="fas fa-plus"></i> Agregar Teléfono
            </button>
        </div>

        <div class="card-body">
            <table id="tabla-telefonos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cod Teléfono</th>
                        <th>Cod Persona</th>
                        <th>Teléfono Personal</th>
                        <th>Segundo Teléfono</th>
                        <th>Teléfono Trabajo</th>
                        <th>Teléfono Fijo</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($telefonos as $t)
                    <tr>
                        <td>{{ $t['cod_telefono'] }}</td>
                        <td>{{ $t['cod_persona'] }}</td>
                        <td>{{ $t['telefono_personal'] }}</td>
                        <td>{{ $t['segundo_telefono'] }}</td>
                        <td>{{ $t['telefono_trabajo'] }}</td>
                        <td>{{ $t['telefono_fijo'] }}</td>
                        <td>{{ $t['observaciones'] }}</td>
                        <td class="text-nowrap">
                            <button class="btn btn-warning btn-sm"
                                onclick="editarTelefono(this)"
                                data-id="{{ $t['cod_telefono'] }}"
                                data-cod-persona="{{ $t['cod_persona'] }}"
                                data-telefono-personal="{{ $t['telefono_personal'] }}"
                                data-segundo-telefono="{{ $t['segundo_telefono'] }}"
                                data-telefono-trabajo="{{ $t['telefono_trabajo'] }}"
                                data-telefono-fijo="{{ $t['telefono_fijo'] }}"
                                data-observaciones="{{ $t['observaciones'] }}">
                                Editar
                            </button>

                            <form action="{{ route('telefonos.destroy', $t['cod_telefono']) }}"
                                  method="POST" style="display:inline-block;"
                                  onsubmit="return confirm('¿Eliminar este teléfono?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center">No hay teléfonos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearTelefono" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('telefonos.store') }}" id="formCrearTelefono">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nuevo teléfono</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cod Persona</label>
                        <input type="number" name="cod_persona" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono Personal</label>
                        <input type="text" name="telefono_personal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Segundo Teléfono</label>
                        <input type="text" name="segundo_telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Trabajo</label>
                        <input type="text" name="telefono_trabajo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Fijo</label>
                        <input type="text" name="telefono_fijo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" class="form-control" maxlength="255"></textarea>
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
<div class="modal fade" id="modalEditarTelefono" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditarTelefono" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar teléfono</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Cod Persona</label>
                        <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono Personal</label>
                        <input type="text" name="telefono_personal" id="edit_telefono_personal" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Segundo Teléfono</label>
                        <input type="text" name="segundo_telefono" id="edit_segundo_telefono" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Trabajo</label>
                        <input type="text" name="telefono_trabajo" id="edit_telefono_trabajo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Teléfono Fijo</label>
                        <input type="text" name="telefono_fijo" id="edit_telefono_fijo" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea name="observaciones" id="edit_observaciones" class="form-control" maxlength="255"></textarea>
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
    $(function(){ $('#tabla-telefonos').DataTable(); });

    function resetCrearTelefono(){ document.getElementById('formCrearTelefono').reset(); }

    function editarTelefono(btn){
        const d = btn.dataset;
        const f = document.getElementById('formEditarTelefono');
        f.action = `/telefonos/${d.id}/actualizar`;

        document.getElementById('edit_cod_persona').value   = d.codPersona;
        document.getElementById('edit_telefono_personal').value = d.telefonoPersonal || '';
        document.getElementById('edit_segundo_telefono').value = d.segundoTelefono || '';
        document.getElementById('edit_telefono_trabajo').value = d.telefonoTrabajo || '';
        document.getElementById('edit_telefono_fijo').value = d.telefonoFijo || '';
        document.getElementById('edit_observaciones').value = d.observaciones || '';

        $('#modalEditarTelefono').modal('show');
    }
</script>
@stop
