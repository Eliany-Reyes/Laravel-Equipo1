@extends('adminlte::page')

@section('title', 'Correos')

@section('content_header')
   <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Correos</h1>
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
            <h3 class="card-title">Listado de Correos</h3>
            <button class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalCrearCorreo"
                    onclick="resetCrearCorreo()">
                <i class="fas fa-plus"></i> Agregar Correo
            </button>
        </div>

        <div class="card-body">
            <table id="tabla-correos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Persona</th>
                        <th>Personal</th>
                        <th>Empleado</th>
                        <th>Secundario</th>
                        <th>Institucional</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($correos as $c)
                        <tr>
                            <td>{{ $c['cod_correos'] ?? '' }}</td>
                            <td>{{ $c['nombre_persona'] ?? $c['cod_persona'] ?? '' }}</td>
                            <td>{{ $c['Correo_personal'] ?? '' }}</td>
                            <td>{{ $c['Correo_empleado'] ?? '' }}</td>
                            <td>{{ $c['Correo_Secuendario'] ?? '' }}</td>
                            <td>{{ $c['Correo_institucional'] ?? '' }}</td>
                            <td>{{ $c['Observaciones'] ?? '' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        onclick="editarCorreo(this)"
                                        data-id="{{ $c['cod_correos'] ?? '' }}"
                                        data-cod-persona="{{ $c['cod_persona'] ?? '' }}"
                                        data-personal="{{ $c['Correo_personal'] ?? '' }}"
                                        data-empleado="{{ $c['Correo_empleado'] ?? '' }}"
                                        data-secundario="{{ $c['Correo_Secuendario'] ?? '' }}"
                                        data-institucional="{{ $c['Correo_institucional'] ?? '' }}"
                                        data-observaciones="{{ $c['Observaciones'] ?? '' }}">
                                    Editar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center">No hay correos registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearCorreo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('correos.store') }}" id="formCrearCorreo">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nuevo correo</h5>
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
                            <label class="form-label">Correo personal</label>
                            <input type="email" name="correo_personal" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo empleado</label>
                            <input type="email" name="correo_empleado" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo secundario</label>
                            <input type="email" name="correo_secundario" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo institucional</label>
                            <input type="email" name="correo_institucional" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <input type="text" name="observaciones" class="form-control">
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
<div class="modal fade" id="modalEditarCorreo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditarCorreo" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar correo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">ID Correo</label>
                            <input type="number" id="edit_cod_correos" class="form-control" readonly>
                            <input type="hidden" name="cod_correos" id="edit_cod_correos_hidden">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Persona (ID)</label>
                            <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo personal</label>
                            <input type="email" name="correo_personal" id="edit_correo_personal" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo empleado</label>
                            <input type="email" name="correo_empleado" id="edit_correo_empleado" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo secundario</label>
                            <input type="email" name="correo_secundario" id="edit_correo_secundario" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Correo institucional</label>
                            <input type="email" name="correo_institucional" id="edit_correo_institucional" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Observaciones</label>
                            <input type="text" name="observaciones" id="edit_observaciones" class="form-control">
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
    $(function(){ $('#tabla-correos').DataTable(); });

    function resetCrearCorreo() {
        const f = document.getElementById('formCrearCorreo');
        if (f) f.reset();
    }

    function editarCorreo(btn) {
        const d = btn.dataset;
        const form = document.getElementById('formEditarCorreo');
        form.action = `/correos/${d.id}/actualizar`;

        document.getElementById('edit_cod_correos').value          = d.id || '';
        document.getElementById('edit_cod_correos_hidden').value   = d.id || '';
        document.getElementById('edit_cod_persona').value          = d.codPersona || '';
        document.getElementById('edit_correo_personal').value      = d.personal || '';
        document.getElementById('edit_correo_empleado').value      = d.empleado || '';
        document.getElementById('edit_correo_secundario').value    = d.secundario || '';
        document.getElementById('edit_correo_institucional').value = d.institucional || '';
        document.getElementById('edit_observaciones').value        = d.observaciones || '';

        $('#modalEditarCorreo').modal('show');
    }
</script>
@stop
