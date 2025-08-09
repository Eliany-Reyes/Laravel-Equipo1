@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
<div class="container">
    <h2>Listado de Permisos</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Permisos</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-permisos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Permisos</th>
                                <th>Id Rol</th>
                                <th>Id Pantalla</th>
                                <th>Puede Ver</th>
                                <th>Puede Crear</th>
                                <th>Puede Editar</th>
                                <th>Puede Eliminar</th>
                                <th>Puede Exportar</th>
                                <th>Restriccion Horario</th>
                                <th>Activo</th>
                                <th>Fecha Creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permisos as $permiso)
                            <tr>
                                <td>{{ $permiso['cod_Permisos'] }}</td>
                                <td>{{ $permiso['id_rol'] }}</td>
                                <td>{{ $permiso['id_pantalla'] }}</td>
                                <td>{{ $permiso['puede_ver'] }}</td>
                                <td>{{ $permiso['puede_crear'] }}</td>
                                <td>{{ $permiso['puede_editar'] }}</td>
                                <td>{{ $permiso['puede_eliminar'] }}</td>
                                <td>{{ $permiso['puede_exportar'] }}</td>
                                <td>{{ $permiso['restriccion_horario'] }}</td>
                                <td>{{ $permiso['activo'] }}</td>
                                <td>{{ $permiso['fecha_creacion'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($permisos))
                                <tr>
                                    <td colspan="11" class="text-center">No hay permisos registrados.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#tabla-permisos').DataTable();
    });
</script>
@stop