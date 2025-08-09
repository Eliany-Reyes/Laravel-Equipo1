@extends('adminlte::page')

@section('title', 'Pantallas')

@section('content_header')
<div class="container">
    <h2>Listado de Pantallas</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Pantallas</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-pantallas" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Pantalla</th>
                                <th>Nombre Pantalla</th>
                                <th>Ruta URL</th>
                                <th>Descripcion</th>
                                <th>Modulo</th>
                                <th>Icono</th>
                                <th>Orden Menu</th>
                                <th>Visible Menu</th>
                                <th>Fecha Creacion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pantallas as $pantalla)
                            <tr>
                                <td>{{ $pantalla['cod_Pantalla'] }}</td>
                                <td>{{ $pantalla['nombre_pantalla'] }}</td>
                                <td>{{ $pantalla['ruta_url'] }}</td>
                                <td>{{ $pantalla['descripcion'] }}</td>
                                <td>{{ $pantalla['modulo'] }}</td>
                                <td>{{ $pantalla['icono'] }}</td>
                                <td>{{ $pantalla['orden_menu'] }}</td>
                                <td>{{ $pantalla['visible_menu'] }}</td>
                                <td>{{ $pantalla['fecha_creacion'] }}</td>
                                <td>{{ $pantalla['estado'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($pantallas))
                                <tr>
                                    <td colspan="10" class="text-center">No hay pantallas registradas.</td>
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
        $('#tabla-pantallas').DataTable();
    });
</script>
@stop