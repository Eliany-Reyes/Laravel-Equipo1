@extends('adminlte::page')

@section('title', 'Direcciones')

@section('content_header')
<div class="container">
    <h2>Listado de Direcciones</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Direcciones</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-direcciones" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Direcciones</th>
                                <th>Cod Persona</th>
                                <th>Direccion Hogar</th>
                                <th>Ciudad</th>
                                <th>Departamento</th>
                                <th>Colonia</th>
                                <th>Codigo Postal</th>
                                <th>Direccion Trabajo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($direcciones as $direccion)
                            <tr>
                                <td>{{ $direccion['cod_direcciones'] }}</td>
                                <td>{{ $direccion['cod_persona'] }}</td>
                                <td>{{ $direccion['Direccion_hogar'] }}</td>
                                <td>{{ $direccion['Ciudad'] }}</td>
                                <td>{{ $direccion['Departamento'] }}</td>
                                <td>{{ $direccion['Colonia'] }}</td>
                                <td>{{ $direccion['Codigo_postal'] }}</td>
                                <td>{{ $direccion['Direccion_trabajo'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($direcciones))
                                <tr>
                                    <td colspan="8" class="text-center">No hay direcciones registradas.</td>
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
        $('#tabla-direcciones').DataTable();
    });
</script>
@stop