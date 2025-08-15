@extends('adminlte::page')

@section('title', 'Personas')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Personas</h1>
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
        <div class="alert alert-danger">{!! nl2br(e(session('error'))) !!}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Listado de Personas</h3>
            <button class="btn btn-primary btn-sm"
                    data-toggle="modal"
                    data-target="#modalCrearPersona"
                    onclick="resetCrearPersona()">
                <i class="fas fa-plus"></i> Nueva Persona
            </button>
        </div>

        <div class="card-body">
            <table id="tabla-personas" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cod Persona</th>
                        <th>Nombre Completo</th>
                        <th>Edad</th>
                        <th>Peso</th>
                        <th>Estado Civil</th>
                        <th>Nacionalidad</th>
                        <th>Fecha Nacimiento</th>
                        <th>Género</th>
                        <th>Idioma</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($personas as $persona)
                    <tr>
                        <td>{{ $persona['cod_persona'] ?? '' }}</td>
                        <td>{{ ($persona['nombre'] ?? '') . ' ' . ($persona['apellido'] ?? '') }}</td>
                        <td>{{ $persona['edad'] ?? '' }}</td>
                        <td>{{ $persona['peso'] ?? '' }}</td>
                        <td>{{ $persona['estado_civil'] ?? '' }}</td>
                        <td>{{ $persona['nacionalidad'] ?? '' }}</td>
                        <td>{{ $persona['fecha_nacimiento'] ?? '' }}</td>
                        <td>{{ $persona['genero'] ?? '' }}</td>
                        <td>{{ $persona['idioma_persona'] ?? '' }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm"
                                    onclick="editarPersona(this)"
                                    data-id="{{ $persona['cod_persona'] ?? '' }}"
                                    data-nombre="{{ $persona['nombre'] ?? '' }}"
                                    data-apellido="{{ $persona['apellido'] ?? '' }}"
                                    data-edad="{{ $persona['edad'] ?? '' }}"
                                    data-peso="{{ $persona['peso'] ?? '' }}"
                                    data-estado="{{ $persona['estado_civil'] ?? '' }}"
                                    data-nacionalidad="{{ $persona['nacionalidad'] ?? '' }}"
                                    data-fecha="{{ $persona['fecha_nacimiento'] ?? '' }}"
                                    data-genero="{{ $persona['genero'] ?? '' }}"
                                    data-idioma="{{ $persona['idioma_persona'] ?? '' }}">
                                Editar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center">No hay personas registradas.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearPersona" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('personas.store') }}" id="formCrearPersona">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nueva persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" name="apellido" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="form-label">Edad</label>
                            <input type="number" name="edad" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" name="peso" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Estado Civil</label>
                            <input type="text" name="estado_civil" class="form-control" maxlength="50">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Nacionalidad</label>
                            <input type="text" name="nacionalidad" class="form-control" maxlength="100">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Fecha Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Género</label>
                            <input type="text" name="genero" class="form-control" maxlength="20">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Idioma</label>
                            <input type="text" name="idioma_persona" class="form-control" maxlength="50">
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
<div class="modal fade" id="modalEditarPersona" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditarPersona" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Nombre</label>
                            <input type="text" id="edit_nombre" name="nombre" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Apellido</label>
                            <input type="text" id="edit_apellido" name="apellido" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="form-label">Edad</label>
                            <input type="number" id="edit_edad" name="edad" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="form-label">Peso (kg)</label>
                            <input type="number" step="0.01" id="edit_peso" name="peso" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Estado Civil</label>
                            <input type="text" id="edit_estado_civil" name="estado_civil" class="form-control" maxlength="50">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Nacionalidad</label>
                            <input type="text" id="edit_nacionalidad" name="nacionalidad" class="form-control" maxlength="100">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Fecha Nacimiento</label>
                            <input type="date" id="edit_fecha_nacimiento" name="fecha_nacimiento" class="form-control">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Género</label>
                            <input type="text" id="edit_genero" name="genero" class="form-control" maxlength="20">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="form-label">Idioma</label>
                            <input type="text" id="edit_idioma_persona" name="idioma_persona" class="form-control" maxlength="50">
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
    $(function(){ $('#tabla-personas').DataTable(); });

    function resetCrearPersona(){
        const f = document.getElementById('formCrearPersona');
        if (f) f.reset();
    }
    
    function toLocal(s){
        if(!s) return '';
        let v = String(s).replace(' ','T').replace('Z','');
        return (v.split('.')[0] || v);
    }

    function editarPersona(btn){
        const d = btn.dataset;
        const form = document.getElementById('formEditarPersona');
        form.action = `/personas/${d.id}/actualizar`;

        document.getElementById('edit_nombre').value = d.nombre || '';
        document.getElementById('edit_apellido').value = d.apellido || '';
        document.getElementById('edit_edad').value = d.edad || '';
        document.getElementById('edit_peso').value = d.peso || '';
        document.getElementById('edit_estado_civil').value = d.estado || '';
        document.getElementById('edit_nacionalidad').value = d.nacionalidad || '';
        document.getElementById('edit_fecha_nacimiento').value = d.fecha || '';
        document.getElementById('edit_genero').value = d.genero || '';
        document.getElementById('edit_idioma_persona').value = d.idioma || '';

        $('#modalEditarPersona').modal('show');
    }
</script>
@stop