@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Listado de Permisos</h1>
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
            <h3 class="card-title mb-0">Listado de Permisos</h3>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalCrearPermiso" onclick="resetCrearPermiso()">
                <i class="fas fa-plus"></i> Agregar Permiso
            </button>
        </div>

        <div class="card-body">
            <table id="tabla-permisos" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>ID Rol</th>
                        <th>ID Pantalla</th>
                        <th>Puede Ver</th>
                        <th>Puede Crear</th>
                        <th>Puede Editar</th>
                        <th>Puede Eliminar</th>
                        <th>Puede Exportar</th>
                        <th>Restricción Horario</th>
                        <th>Activo</th>
                        <th>Fecha Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($permisos as $p)
                    <tr>
                        <td>{{ $p['cod_Permisos'] }}</td>
                        <td>{{ $p['id_rol'] }}</td>
                        <td>{{ $p['id_pantalla'] }}</td>
                        <td>{{ $p['puede_ver'] ? 'Sí' : 'No' }}</td>
                        <td>{{ $p['puede_crear'] ? 'Sí' : 'No' }}</td>
                        <td>{{ $p['puede_editar'] ? 'Sí' : 'No' }}</td>
                        <td>{{ $p['puede_eliminar'] ? 'Sí' : 'No' }}</td>
                        <td>{{ $p['puede_exportar'] ? 'Sí' : 'No' }}</td>
                        <td>{{ $p['restriccion_horario'] ?? '-' }}</td>
                        <td>{{ $p['activo'] ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $p['fecha_creacion'] ?? '' }}</td>
                        <td class="text-nowrap">
                            <button class="btn btn-warning btn-sm"
                                onclick="editarPermiso(this)"
                                data-id="{{ $p['cod_Permisos'] }}"
                                data-id-rol="{{ $p['id_rol'] }}"
                                data-id-pantalla="{{ $p['id_pantalla'] }}"
                                data-ver="{{ $p['puede_ver'] }}"
                                data-crear="{{ $p['puede_crear'] }}"
                                data-editar="{{ $p['puede_editar'] }}"
                                data-eliminar="{{ $p['puede_eliminar'] }}"
                                data-exportar="{{ $p['puede_exportar'] }}"
                                data-restriccion="{{ $p['restriccion_horario'] ?? '' }}"
                                data-activo="{{ $p['activo'] }}"
                                data-fecha="{{ $p['fecha_creacion'] ?? '' }}">
                                <i class="fas fa-edit"></i> Editar
                            </button>

                            <form action="{{ route('permisos.destroy', $p['cod_Permisos']) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar este permiso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="12" class="text-center">No hay permisos registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearPermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('permisos.store') }}" id="formCrearPermiso">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nuevo permiso</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>ID Rol</label>
                        <input type="number" name="id_rol" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ID Pantalla</label>
                        <input type="number" name="id_pantalla" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Puede Ver</label>
                        <select name="puede_ver" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Crear</label>
                        <select name="puede_crear" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Editar</label>
                        <select name="puede_editar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Eliminar</label>
                        <select name="puede_eliminar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Exportar</label>
                        <select name="puede_exportar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Restricción Horario</label>
                        <input type="text" name="restriccion_horario" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Activo</label>
                        <select name="activo" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Creación</label>
                        <input type="datetime-local" name="fecha_creacion" class="form-control">
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
<div class="modal fade" id="modalEditarPermiso" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="formEditarPermiso" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar permiso</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>ID Rol</label>
                        <input type="number" name="id_rol" id="edit_id_rol" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>ID Pantalla</label>
                        <input type="number" name="id_pantalla" id="edit_id_pantalla" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Puede Ver</label>
                        <select name="puede_ver" id="edit_puede_ver" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Crear</label>
                        <select name="puede_crear" id="edit_puede_crear" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Editar</label>
                        <select name="puede_editar" id="edit_puede_editar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Eliminar</label>
                        <select name="puede_eliminar" id="edit_puede_eliminar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Puede Exportar</label>
                        <select name="puede_exportar" id="edit_puede_exportar" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Restricción Horario</label>
                        <input type="text" name="restriccion_horario" id="edit_restriccion_horario" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Activo</label>
                        <select name="activo" id="edit_activo" class="form-control" required>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Creación</label>
                        <input type="datetime-local" name="fecha_creacion" id="edit_fecha_creacion" class="form-control">
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
    $(function(){ $('#tabla-permisos').DataTable(); });

    function resetCrearPermiso(){ document.getElementById('formCrearPermiso').reset(); }

    function editarPermiso(btn){
        const d = btn.dataset;
        const f = document.getElementById('formEditarPermiso');
        f.action = `/permisos/${d.id}`;

        const toDatetimeLocal = (s) => {
            if (!s) return '';
            const dt = new Date(s);
            const pad = (n) => n.toString().padStart(2, '0');
            const yyyy = dt.getFullYear();
            const mm = pad(dt.getMonth()+1);
            const dd = pad(dt.getDate());
            const hh = pad(dt.getHours());
            const min = pad(dt.getMinutes());
            return `${yyyy}-${mm}-${dd}T${hh}:${min}`;
        };

        document.getElementById('edit_id_rol').value = d.idRol || '';
        document.getElementById('edit_id_pantalla').value = d.idPantalla || '';
        document.getElementById('edit_puede_ver').value = d.ver || '0';
        document.getElementById('edit_puede_crear').value = d.crear || '0';
        document.getElementById('edit_puede_editar').value = d.editar || '0';
        document.getElementById('edit_puede_eliminar').value = d.eliminar || '0';
        document.getElementById('edit_puede_exportar').value = d.exportar || '0';
        document.getElementById('edit_restriccion_horario').value = d.restriccion || '';
        document.getElementById('edit_activo').value = d.activo || '0';
        document.getElementById('edit_fecha_creacion').value = toDatetimeLocal(d.fecha);

        $('#modalEditarPermiso').modal('show');
    }
</script>
@stop