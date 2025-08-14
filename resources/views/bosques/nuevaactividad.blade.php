@extends('adminlte::page')

@section('title', 'Insertar Actividad')

@section('content_header')
<div class="container">
    <h2>Insertar Nueva Actividad</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Inserción</h3>
                </div>
                <form action="{{ route('actividades.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        <div class="form-group">
                            <label for="cod_bosque">Código de Bosque</label>
                            <select class="form-control @error('cod_bosque') is-invalid @enderror" id="cod_bosque" name="cod_bosque" required>
                                <option value="" disabled selected>Selecciona un bosque</option>
                                @if(isset($bosques) && is_array($bosques) && count($bosques) > 0)
                                    @foreach($bosques as $bosque)
                                        <option value="{{ $bosque['cod_bosque'] ?? '' }}" {{ old('cod_bosque') == ($bosque['cod_bosque'] ?? '') ? 'selected' : '' }}>
                                            {{ $bosque['nombre_bosque'] ?? 'N/A' }} ({{ $bosque['cod_bosque'] ?? '' }})
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>No se pudieron cargar los bosques</option>
                                @endif
                            </select>
                            @error('cod_bosque')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion_actividad">Descripción de la Actividad</label>
                            <textarea class="form-control @error('descripcion_actividad') is-invalid @enderror" id="descripcion_actividad" name="descripcion_actividad" rows="3" required>{{ old('descripcion_actividad') }}</textarea>
                            @error('descripcion_actividad')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="espacios_disponibles">Espacios Disponibles</label>
                            <input type="number" class="form-control @error('espacios_disponibles') is-invalid @enderror" id="espacios_disponibles" name="espacios_disponibles" min="1" step="1" value="{{ old('espacios_disponibles', 1) }}" required>
                            @error('espacios_disponibles')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Actividad</button>
                        <a href="{{ route('actividades.pantalla') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop