@extends('adminlte::page') {{-- Extiende la plantilla base de AdminLTE --}}

@section('title', 'Flora y Fauna') {{-- Título de la página --}}

@section('content_header') {{-- Encabezado de contenido de la página --}}
<div class="container-fluid d-flex justify-content-between align-items-center">
    <h2 class="text-center flex-grow-1">Listado de Flora y Fauna</h2>
    <a href="{{ route('bosques.menu') }}" class="btn btn-success">
        <i class="fas fa-arrow-left"></i> Regresar
    </a>
</div>
@endsection {{-- Cierra la sección 'content_header' --}}

@section('content') {{-- Contenido principal de la página --}}
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Especies Disponibles</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-flora-fauna" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código Flora/Fauna</th>
                                <th>Código Bosque</th>
                                <th>Tipo</th>
                                <th>Estado</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Itera sobre la variable $floraFauna --}}
                            @if (!empty($floraFauna))
                                @foreach($floraFauna as $item)
                                <tr>
                                    {{-- Accede a las propiedades del objeto $item con las claves correctas --}}
                                    <td>{{ $item['cod_flora_fauna'] ?? 'N/A' }}</td>
                                    <td>{{ $item['cod_bosque'] ?? 'N/A' }}</td>
                                    <td>{{ $item['tipo_especie'] ?? 'N/A' }}</td>
                                    <td>{{ $item['estado_conservacion'] ?? 'N/A' }}</td>
                                    <td>{{ $item['descripcion_especie'] ?? 'Sin descripción' }}</td>
                                </tr>
                                @endforeach
                            @else
                                {{-- Muestra un mensaje si no hay datos --}}
                                <tr>
                                    <td colspan="5" class="text-center">No se encontraron datos de flora y fauna.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection {{-- Cierra la sección 'content' --}}

@section('js') {{-- Sección para scripts JavaScript --}}
<script>
    $(document).ready(function() {
        $('#tabla-flora-fauna').DataTable();
    });
</script>
@endsection {{-- Cierra la sección 'js' --}}
