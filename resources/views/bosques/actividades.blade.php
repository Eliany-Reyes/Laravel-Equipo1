@extends('adminlte::page')

@section('title', 'Gestión de Actividades')

@section('content_header')
<div class="container text-center">
    <h2 class="text-3xl font-bold leading-tight text-gray-900">
        Gestión de Actividades
    </h2>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        @if(session('success'))
        <div class="col-12 mb-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
        @if(session('error'))
        <div class="col-12 mb-4">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        @endif
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    {{-- Contenedor del botón de regreso y el título --}}
                    <div class="d-flex align-items-center">
                        <a href="{{ route('actividades.pantalla') }}" class="btn btn-success mr-2">
                            <i class="fas fa-home"></i>
                        </a>
                        <h3 class="card-title mb-0">Listado de Actividades</h3>
                    </div>
                    {{-- Botón para crear una nueva actividad --}}
                    <a href="{{ route('actividades.create') }}" class="btn btn-success ml-auto">
                        <i class="fas fa-plus"></i> Añadir Actividad
                    </a>
                </div>
                <div class="card-body">
                    <table id="tabla-actividades" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod. Actividad</th>
                                <th>Cod. Bosque</th>
                                <th>Descripción</th>
                                <th>Espacios Disponibles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($actividades as $actividad)
                            <tr>
                                <td>{{ $actividad['cod_actividad'] }}</td>
                                <td>{{ $actividad['cod_bosque'] }}</td>
                                <td>{{ $actividad['descripcion_actividad'] }}</td>
                                <td>{{ $actividad['espacios_disponibles'] }}</td>
                                <td>
                                    {{-- Contenedor para los botones de acción --}}
                                    <div class="d-flex flex-column flex-sm-row justify-content-center align-items-center">
                                        {{-- Botón para editar --}}
                                        <a href="{{ route('actividades.edit', $actividad['cod_actividad']) }}" class="btn btn-success btn-sm mb-2 mb-sm-0 mr-sm-2">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        {{-- Formulario para eliminar --}}
                                        <form action="{{ route('actividades.destroy', $actividad['cod_actividad']) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta actividad?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay actividades registradas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#tabla-actividades').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            responsive: true,
        });
    });
</script>
@endsection