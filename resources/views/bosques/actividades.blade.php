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
                    <div class="d-flex align-items-center">
                        <a href="{{ route('actividades.pantalla') }}" class="btn btn-success mr-2">
                            <i class="fas fa-home"></i>
                        </a>
                        <h3 class="card-title mb-0">Listado de Actividades</h3>
                    </div>
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
                            @foreach($actividades as $actividad)
                            <tr>
                                <td>{{ $actividad['cod_actividad'] }}</td>
                                <td>{{ $actividad['cod_bosque'] }}</td>
                                <td>{{ $actividad['descripcion_actividad'] }}</td>
                                <td>{{ $actividad['espacios_disponibles'] }}</td>
                                <td>
                                    <a href="{{ route('actividades.create') }}" class="btn btn-success btn-sm mb-1 d-block">
                                        <i class="fas fa-plus"></i> Insertar
                                    </a>
                                    <a href="{{ route('actividades.edit', $actividad['cod_actividad']) }}" class="btn btn-success btn-sm d-block">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($actividades))
                                <tr>
                                    <td colspan="5" class="text-center">No hay actividades registradas.</td>
                                </tr>
                            @endif
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
            }
        });
    });
</script>
@endsection