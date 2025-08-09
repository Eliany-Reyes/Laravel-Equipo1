@extends('adminlte::page')

@section('title', 'Correos')

@section('content_header')
<div class="container">
    <h2>Listado de Correos</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Correos</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-correos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Correos</th>
                                <th>Cod Persona</th>
                                <th>Correo Personal</th>
                                <th>Correo Empleado</th>
                                <th>Correo Secuendario</th>
                                <th>Correo Institucional</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($correos as $correo)
                            <tr>
                                <td>{{ $correo['cod_correos'] }}</td>
                                <td>{{ $correo['cod_persona'] }}</td>
                                <td>{{ $correo['Correo_personal'] }}</td>
                                <td>{{ $correo['Correo_empleado'] }}</td>
                                <td>{{ $correo['Correo_Secuendario'] }}</td>
                                <td>{{ $correo['Correo_institucional'] }}</td>
                                <td>{{ $correo['Observaciones'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($correos))
                                <tr>
                                    <td colspan="7" class="text-center">No hay correos registrados.</td>
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
        $('#tabla-correos').DataTable();
    });
</script>
@stop