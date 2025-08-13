@extends('adminlte::page')
@section('title', 'Mantenimientos')

@section('content_header')
<div class="container">
    <h2>Listado de Mantenimientos</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Mantenimientos</h3>

                     <a href="{{ route('mantenimientos.index_pantalla') }}" class="btn btn-primary float-right">Regresar</a>
                    
                    <a href="{{ route('mantenimientos.create') }}" class="btn btn-success mt-3">Crear Nuevo Mantenimiento</a>
                </div>
                <div class="card-body">
                    <table id="tabla-mantenimientos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Mantenimiento</th>
                                <th>Cod Bosque</th>
                                <th>Tipo Mantenimiento</th>
                                <th>Fecha Mantenimiento</th>
                                <th>Descripción</th>
                                <th>Materiales</th>
                                <th>Estado Bosque</th>
                                 <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mantenimientos as $mantenimiento)
                            <tr>
                                <td>{{ $mantenimiento['cod_mantenimiento'] }}</td>
                                <td>{{ $mantenimiento['cod_bosque'] }}</td>
                                <td>{{ $mantenimiento['tipo_mantenimiento'] }}</td>
                                <td>{{ $mantenimiento['fecha_mantenimiento'] }}</td>
                                <td>{{ $mantenimiento['descripcion_Man'] }}</td>
                                <td>{{ $mantenimiento['materiales_Man'] }}</td>
                                <td>{{ $mantenimiento['estado_Bosque'] }}</td>
                                <td>
                                    {{-- El botón ahora envía el ID directamente a la ruta de edición. --}}
                                    <a href="{{ route('mantenimientos.edit', ['id' => $mantenimiento['cod_mantenimiento']]) }}" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar">
                                        <i class="fa fa-lg fa-fw fa-pen"></i>
                                    </a>

                                     {{-- Formulario para eliminar --}}
                                    <form action="{{ route('mantenimientos.destroy', $mantenimiento['cod_mantenimiento']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este mantenimiento?');">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>
                                    
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($mantenimientos))
                                <tr>
                                    <td colspan="7" class="text-center">No hay mantenimientos registrados.</td>
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
        $('#tabla-mantenimientos').DataTable();
    });
</script>
@stop
