@extends('adminlte::page')

@section('title', 'Reservas')


@section('content_header')
<div class="container">
    <h2 style="text-align: center;">Listado de Reservas
        <a href="{{ route('reserva.create') }}" class="btn btn-primary ml-2">Insertar Nuevo</a>
    </h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        
         @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Reservas</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-reservas" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Reserva</th>
                                <th>Cod Evento</th>
                                <th>Cod Persona </th>
                                <th>Hora Reserva</th>
                                <th>Dia Reserva</th>
                                <th>Cantidad Persona </th>
                                <th>ISV Reserva </th>
                                <th>Sub Total </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservas as $reserva)
                            <tr>
                                <td>{{ $reserva['cod_reserva'] }}</td>
                                <td>{{ $reserva['cod_evento'] }}</td>
                                <td>{{ $reserva['cod_persona'] }}</td>
                                <td>{{ $reserva['hora_reserva'] }}</td>
                                <td>{{ $reserva['dia_reserva'] }}</td>
                                <td>{{ $reserva['cant_persona'] }}</td>
                                <td>{{ $reserva['isv_reserva'] }}</td>
                                <td>{{ $reserva['sub_total'] }}</td>
                                <td> 
                                    <a href="{{ route('reserva.edit', $reserva['cod_reserva']) }}" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('reserva.destroy', $reserva['cod_reserva']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento?');">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($reservas))
                                <tr>
                                    <td colspan="8" class="text-center">No hay reservas registrados.</td>
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
        $('#tabla-reservas').DataTable();
    });
</script>
@stop