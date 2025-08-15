@extends('adminlte::page')

@section('title', 'Gestión de Bosques')

@section('content_header')
<div class="container text-center">
    <h2 class="text-3xl font-bold leading-tight text-gray-900">
        Gestión de Bosques
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="col-12 mb-4">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                    <!-- Botón de casita para regresar al inicio y título del listado a la izquierda -->
                    <div class="d-flex align-items-center">
                        <a href="{{ route('bosques.pantalla') }}" class="btn btn-success mr-2">
                            <i class="fas fa-home"></i>
                        </a>
                        <h3 class="card-title mb-0">Listado de Bosques</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabla-bosques" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod. Bosque</th>
                                <th>Nombre</th>
                                <th>Departamento</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bosques as $bosques)
                            <tr>
                                <td>{{ $bosques['cod_bosque'] }}</td>
                                <td>{{ $bosques['nombre_bosque'] }}</td>
                                <td>{{ $bosques['departamento'] }}</td>
                                <td>{{ $bosques['tipo_bosque'] }}</td>
                                <td>{{ $bosques['descripcion_bosque'] }}</td>
                                <td>{{ $bosques['estado_bosque'] }}</td>
                                <td>
                                    <a href="{{ route('bosques.create') }}" class="btn btn-success btn-sm mb-1 d-block">
                                        <i class="fas fa-plus"></i>
                                        Insertar
                                    </a>
                                    <a href="{{ route('bosques.edit', $bosques['cod_bosque']) }}" class="btn btn-success btn-sm d-block">
                                        Editar
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($bosques))
                                <tr>
                                    <td colspan="7" class="text-center">No hay bosques registrados.</td>
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
        $('#tabla-bosques').DataTable();
    });
</script>
@endsection
