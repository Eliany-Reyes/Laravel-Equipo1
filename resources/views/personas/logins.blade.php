@extends('adminlte::page')

@section('title', 'Logins')

@section('content_header')
<div class="container">
    <h2>Listado de Logins</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Logins</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-logins" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Login</th>
                                <th>Fecha Login</th>
                                <th>IP Usuario</th>
                                <th>Navegador</th>
                                <th>Exito Login</th>
                                <th>Cod Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logins as $login)
                            <tr>
                                <td>{{ $login['cod_Login'] }}</td>
                                <td>{{ $login['fecha_login'] }}</td>
                                <td>{{ $login['ip_usuario'] }}</td>
                                <td>{{ $login['navegador'] }}</td>
                                <td>{{ $login['exito_login'] }}</td>
                                <td>{{ $login['cod_usuario'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($logins))
                                <tr>
                                    <td colspan="6" class="text-center">No hay logins registrados.</td>
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
        $('#tabla-logins').DataTable();
    });
</script>
@stop