@extends('adminlte::page')

@section('title', 'Insertar Nuevo Acceso')

@section('content_header')
<div class="container text-center">
    <h2 class="text-3xl font-bold leading-tight text-gray-900">
        INSERTAR NUEVO ACCESO
    </h2>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Mensajes de sesión para éxito o error --}}
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
                        <a href="{{ route('acceso.index') }}" class="btn btn-success mr-2">
                            <i class="fas fa-arrow-left"></i> Regresar
                        </a>
                        <h3 class="card-title mb-0">Formulario de Nuevo Acceso</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('acceso.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            {{-- Campo: Código de Bosque (Select dinámico) --}}
                            <div class="form-group">
                                <label for="cod_bosque">Bosque</label>
                                <select id="cod_bosque" name="cod_bosque" class="form-control" required>
                                    <option value="" disabled selected>Selecciona un bosque</option>
                                    {{-- Aquí se iterará sobre la variable $bosques --}}
                                    @foreach($bosques as $bosque)
                                        <option value="{{ $bosque['cod_bosque'] }}">{{ $bosque['nombre_bosque'] }} ({{ $bosque['cod_bosque'] }})</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Campo: Tipo de Ruta --}}
                            <div class="form-group">
                                <label for="tipo_ruta">Tipo de Ruta</label>
                                <input type="text" id="tipo_ruta" name="tipo_ruta" class="form-control" placeholder="Ej: Carretera Principal" required>
                            </div>
                            {{-- Campo: Estado de Ruta --}}
                            <div class="form-group">
                                <label for="estado_ruta">Estado de la Ruta</label>
                                <input type="text" id="estado_ruta" name="estado_ruta" class="form-control" placeholder="Ej: Excelente" required>
                            </div>
                            {{-- Campo: Recomendaciones --}}
                            <div class="form-group">
                                <label for="recomendaciones">Recomendaciones</label>
                                <textarea id="recomendaciones" name="recomendaciones" rows="3" class="form-control" placeholder="Ej: Acceso para todo tipo de vehículo" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">Guardar  Acceso</button>
                                <a href="{{ route('acceso.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
