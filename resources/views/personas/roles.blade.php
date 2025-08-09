@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
<div class="container">
    <h2>Listado de Roles</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Roles</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-roles" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Rol</th>
                                <th>Nombre Rol</th>
                                <th>Descripcion</th>
                                <th>Nivel Acceso</th>
                                <th>Permisos</th>
                                <th>Creado Por</th>
                                <th>Fecha Creacion</th>
                                <th>Ultima Modificacion</th>
                                <th>Activo</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $rol)
                            <tr>
                                <td>{{ $rol['cod_rol'] }}</td>
                                <td>{{ $rol['nombre_rol'] }}</td>
                                <td>{{ $rol['descripcion'] }}</td>
                                <td>{{ $rol['nivel_acceso'] }}</td>
                                <td>{{ $rol['permisos'] }}</td>
                                <td>{{ $rol['creado_por'] }}</td>
                                <td>{{ $rol['fecha_creacion'] }}</td>
                                <td>{{ $rol['ultima_modificacion'] }}</td>
                                <td>{{ $rol['activo'] }}</td>
                                <td>{{ $rol['observaciones'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($roles))
                                <tr>
                                    <td colspan="10" class="text-center">No hay roles registrados.</td>
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
        $('#tabla-roles').DataTable();
    });
</script>
@stop