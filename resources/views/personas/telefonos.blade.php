@extends('adminlte::page')

@section('title', 'Telefonos')

@section('content_header')
<div class="container">
    <h2>Listado de Telefonos</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Telefonos</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-telefonos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Telefono</th>
                                <th>Cod Persona</th>
                                <th>Telefono Personal</th>
                                <th>Segundo Telefono</th>
                                <th>Telefono Trabajo</th>
                                <th>Telefono Fijo</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($telefonos as $telefono)
                            <tr>
                                <td>{{ $telefono['cod_telefono'] }}</td>
                                <td>{{ $telefono['cod_persona'] }}</td>
                                <td>{{ $telefono['telefono_personal'] }}</td>
                                <td>{{ $telefono['Segundo_Telefono'] }}</td>
                                <td>{{ $telefono['telefono_trabajo'] }}</td>
                                <td>{{ $telefono['telefono_fijo'] }}</td>
                                <td>{{ $telefono['observaciones'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($telefonos))
                                <tr>
                                    <td colspan="7" class="text-center">No hay telefonos registrados.</td>
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
        $('#tabla-telefonos').DataTable();
    });
</script>
@stop