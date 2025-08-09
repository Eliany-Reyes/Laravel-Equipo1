@extends('adminlte::page')

@section('title', 'Empleados Roles')

@section('content_header')
<div class="container">
    <h2>Listado de Empleados Roles</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Empleados Roles</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-empleados_roles" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Empleado</th>
                                <th>Cod Rol</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados_roles as $empleado_rol)
                            <tr>
                                <td>{{ $empleado_rol['cod_empleado'] }}</td>
                                <td>{{ $empleado_rol['cod_rol'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($empleados_roles))
                                <tr>
                                    <td colspan="2" class="text-center">No hay empleados roles registrados.</td>
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
        $('#tabla-empleados_roles').DataTable();
    });
</script>
@stop