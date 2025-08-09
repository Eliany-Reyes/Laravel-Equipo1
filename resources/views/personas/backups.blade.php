@extends('adminlte::page')

@section('title', 'Backups')

@section('content_header')
<div class="container">
    <h2>Listado de Backups</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Backups</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-backups" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Backup</th>
                                <th>Fecha Backup</th>
                                <th>Ruta Archivo</th>
                                <th>Descripcion</th>
                                <th>Realizado Por</th>
                                <th>Cod Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                            <tr>
                                <td>{{ $backup['cod_Backup'] }}</td>
                                <td>{{ $backup['fecha_backup'] }}</td>
                                <td>{{ $backup['ruta_archivo'] }}</td>
                                <td>{{ $backup['descripcion'] }}</td>
                                <td>{{ $backup['realizado_por'] }}</td>
                                <td>{{ $backup['cod_usuario'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($backups))
                                <tr>
                                    <td colspan="6" class="text-center">No hay backups registrados.</td>
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
        $('#tabla-backups').DataTable();
    });
</script>
@stop