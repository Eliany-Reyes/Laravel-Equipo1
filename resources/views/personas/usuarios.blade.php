@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Usuarios</h1>
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
            <h3 class="card-title mb-0">Listado de Usuarios</h3>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearUsuario" onclick="resetCrearUsuario()">
                <i class="fas fa-plus"></i> Agregar Usuario
            </button>
        </div>

        <div class="card-body">
            <table id="tabla-usuarios" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Cod Usuario</th>
                        <th>Cod Persona</th>
                        <th>Nombre Usuario</th>
                        <th>Correo Electrónico</th>
                        <th>ID Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($usuarios as $u)
                    <tr>
                        <td>{{ $u['cod_usuario'] }}</td>
                        <td>{{ $u['cod_persona'] }}</td>
                        <td>{{ $u['nombre_usuario'] }}</td>
                        <td>{{ $u['correo_electronico'] }}</td>
                        <td>{{ $u['id_rol'] }}</td>
                        <td>{{ $u['estado'] ? 'Activo' : 'Inactivo' }}</td>
                        <td class="text-nowrap">
                            <div class="d-flex gap-2">
                                <button class="btn btn-warning btn-sm"
                                    onclick="editarUsuario(this)"
                                    data-id="{{ $u['cod_usuario'] }}"
                                    data-cod-persona="{{ $u['cod_persona'] }}"
                                    data-nombre="{{ $u['nombre_usuario'] }}"
                                    data-correo="{{ $u['correo_electronico'] }}"
                                    data-id-rol="{{ $u['id_rol'] }}"
                                    data-estado="{{ $u['estado'] }}">
                                    Editar
                                </button>
                                <form action="{{ route('usuarios.destroy', $u['cod_usuario']) }}"
                                    method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No hay usuarios registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('usuarios.store') }}" id="formCrearUsuario">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nuevo usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="cod_persona_crear">Código de Persona</label>
                        <input type="number" name="cod_persona" id="cod_persona_crear" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre_usuario_crear">Nombre de Usuario</label>
                        <input type="text" name="nombre_usuario" id="nombre_usuario_crear" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_electronico_crear">Correo Electrónico</label>
                        <input type="email" name="correo_electronico" id="correo_electronico_crear" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="id_rol_crear">ID Rol</label>
                        <input type="number" name="id_rol" id="id_rol_crear" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena_crear">Contraseña</label>
                        <input type="password" name="contrasena" id="contrasena_crear" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="estado_crear">Estado</label>
                        <select name="estado" id="estado_crear" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formEditarUsuario" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_cod_persona">Código de Persona</label>
                        <input type="number" name="cod_persona" id="edit_cod_persona" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nombre_usuario">Nombre de Usuario</label>
                        <input type="text" name="nombre_usuario" id="edit_nombre_usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_correo_electronico">Correo Electrónico</label>
                        <input type="email" name="correo_electronico" id="edit_correo_electronico" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_id_rol">ID Rol</label>
                        <input type="number" name="id_rol" id="edit_id_rol" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_contrasena">Contraseña (dejar vacío para no cambiar)</label>
                        <input type="password" name="contrasena" id="edit_contrasena" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="edit_estado">Estado</label>
                        <select name="estado" id="edit_estado" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(function(){ $('#tabla-usuarios').DataTable(); });

    function resetCrearUsuario(){ document.getElementById('formCrearUsuario').reset(); }

    function editarUsuario(btn) {
        const d = btn.dataset;
        const f = document.getElementById('formEditarUsuario');
        f.action = `/usuarios/${d.id}`;

        document.getElementById('edit_cod_persona').value = d.codPersona || '';
        document.getElementById('edit_nombre_usuario').value = d.nombre || '';
        document.getElementById('edit_correo_electronico').value = d.correo || '';
        document.getElementById('edit_id_rol').value = d.idRol || '';
        document.getElementById('edit_estado').value = d.estado || '0';

        $('#modalEditarUsuario').modal('show');
    }
</script>
@stop