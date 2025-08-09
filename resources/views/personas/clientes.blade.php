@extends('adminlte::page')

@section('title', 'Clientes') {{-- Título de la página actualizado --}}

@section('content_header')
<div class="container">
    <h2>Listado de Clientes</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Clientes</h3>
                    {{-- No se añade el botón "Agregar Cliente" para ser idéntico al base de personas sin ese botón --}}
                </div>
                <div class="card-body">
                    <table id="tabla-clientes" class="table table-bordered table-striped"> {{-- ID cambiado --}}
                        <thead>
                            <tr>
                                <th>Cod Cliente</th>
                                <th>Cod Persona</th>
                                <th>Fecha Registro</th>
                                <th>Tipo Cliente</th>
                                <th>Motivo Visita</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clientes as $cliente) {{-- Cambiado de $personas a $clientes --}}
                            <tr>
                                <td>{{ $cliente['cod_Cliente'] }}</td>
                                <td>{{ $cliente['cod_persona'] }}</td>
                                <td>{{ $cliente['fecha_registro'] }}</td>
                                <td>{{ $cliente['tipo_cliente'] }}</td>
                                <td>{{ $cliente['motivo_visita'] }}</td>
                            </tr>
                            @endforeach
                            @if(empty($clientes)) {{-- Mensaje si no hay clientes --}}
                                <tr>
                                    <td colspan="5" class="text-center">No hay clientes registrados.</td> {{-- colspan ajustado al número de columnas --}}
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
        $('#tabla-clientes').DataTable(); {{-- ID cambiado --}}
    });
</script>
@stop