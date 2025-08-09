@extends('adminlte::page')

@section('title', 'Empleados')

@section('content_header')
<div class="container">
    <h2>Listado de Empleados</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Empleados</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-empleados" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Empleado</th>
                                <th>Cod Persona</th>
                                <th>Cargo</th>
                                <th>Area Asignada</th>
                                <th>Fecha Contratacion</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empleados as $empleado)
                            <tr>
                                <td>{{ $empleado['cod_empleado'] }}</td>
                                <td>{{ $empleado['cod_persona'] }}</td>
                                <td>{{ $empleado['cargo'] }}</td>
                                <td>{{ $empleado['area_asignada'] }}</td>
                                <td>{{ $empleado['fecha_contratacion'] }}</td>
                                <td>{{ $empleado['salario'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($empleados))
                                <tr>
                                    <td colspan="6" class="text-center">No hay empleados registrados.</td>
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
        $('#tabla-empleados').DataTable();
    });
</script>
@stop