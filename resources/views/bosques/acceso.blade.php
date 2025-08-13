@extends('adminlte::page')

@section('title', 'Gestión de Accesos')

@section('content_header')
<div class="container text-center">
    <h2 class="text-3xl font-bold leading-tight text-gray-900">
        Gestión de Accesos a Bosques
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
                    {{-- Botón de regreso al menú de bosques --}}
                    <div class="d-flex align-items-center">
                        <a href="{{ route('acceso.pantalla') }}" class="btn btn-success mr-2">
                            <i class="fas fa-home"></i>
                        </a>
                        <h3 class="card-title mb-0">Listado de Accesos</h3>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tabla-accesos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código Acceso</th>
                                <th>Código Bosque</th>
                                <th>Tipo de Ruta</th>
                                <th>Estado de Ruta</th>
                                <th>Recomendaciones</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($accesos as $acceso)
                            <tr>
                                <td>{{ $acceso['cod_acceso'] ?? 'N/A' }}</td>
                                <td>{{ $acceso['cod_bosque'] ?? 'N/A' }}</td>
                                <td>{{ $acceso['tipo_ruta'] ?? 'N/A' }}</td>
                                <td>{{ $acceso['estado_ruta'] ?? 'N/A' }}</td>
                                <td>{{ $acceso['recomendaciones'] ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        {{-- Botón para editar --}}
                                        <a href="{{ route('acceso.edit', $acceso['cod_acceso']) }}" class="btn btn-success btn-sm mb-1 d-block">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        {{-- Formulario para eliminar --}}
                                        <form action="{{ route('acceso.destroy', $acceso['cod_acceso']) }}" method="POST" class="d-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este acceso?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-success btn-sm d-block w-100">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay accesos registrados.</td>
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
        $('#tabla-accesos').DataTable({
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });
    });
</script>
@endsection
