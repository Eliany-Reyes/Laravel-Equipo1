@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
<div class="container">
    <h2 style="text-align: center;">Listado de Eventos
        <a href="{{ route('eventos.create') }}" class="btn btn-primary ml-2">Insertar Nuevo</a>
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
                    <h3 class="card-title">Listado de Eventos</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-eventos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Evento</th>
                                <th>Cod Bosque</th>
                                <th>Tipo de Evento</th>
                                <th>Descripcion Evento</th>
                                <th>Precio Evento</th>
                                <th>Cantidad Maxima </th>
                                <th>Restricciones </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                            <tr>
                                <td>{{ $evento['cod_evento'] }}</td>
                                <td>{{ $evento['cod_bosque'] }}</td>
                                <td>{{ $evento['tipo_evento'] }}</td>
                                <td>{{ $evento['descripcion_evento'] }}</td>
                                <td>{{ $evento['precio_evento'] }}</td>
                                <td>{{ $evento['cantidad_maxima'] }}</td>
                                <td>{{ $evento['restricciones'] }}</td>
                                <td>
                                    <a href="{{ route('eventos.edit', $evento['cod_evento']) }}" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('eventos.destroy', $evento['cod_evento']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento?');">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                        
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($eventos))
                                <tr>
                                    <td colspan="7" class="text-center">No hay eventos registrados.</td>
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
        $('#tabla-eventos').DataTable();

    });
</script>
@stop