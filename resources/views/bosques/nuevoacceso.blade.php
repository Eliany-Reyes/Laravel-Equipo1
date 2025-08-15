@extends('adminlte::page')

@section('title', 'Insertar Acceso')

@section('content_header')
<div class="container-fluid text-center">
    <h2 class="font-weight-bold"><i class="fas fa-edit"></i> Insertar Nuevo Acceso</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Formulario de Inserción</h3>
                </div>
                <form action="{{ route('acceso.store') }}" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Menú desplegable para seleccionar el bosque --}}
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

                        {{-- Campo para el Tipo de Ruta --}}
                        <div class="form-group">
                            <label for="tipo_ruta">Tipo de Ruta</label>
                            <select class="form-control @error('tipo_ruta') is-invalid @enderror" id="tipo_ruta" name="tipo_ruta" required>
                                <option value="" disabled selected>Selecciona un tipo de ruta</option>
                                <option value="Terrestre" {{ old('tipo_ruta') == 'Terrestre' ? 'selected' : '' }}>Terrestre</option>
                                <option value="Acuática" {{ old('tipo_ruta') == 'Acuática' ? 'selected' : '' }}>Acuática</option>
                                <option value="Aérea" {{ old('tipo_ruta') == 'Aérea' ? 'selected' : '' }}>Aérea</option>
                            </select>
                            @error('tipo_ruta')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        
                        {{-- Campo para el Estado de Ruta --}}
                        <div class="form-group">
                            <label for="estado_ruta">Estado de Ruta</label>
                            <select class="form-control @error('estado_ruta') is-invalid @enderror" id="estado_ruta" name="estado_ruta" required>
                                <option value="" disabled selected>Selecciona el estado</option>
                                <option value="Abierta" {{ old('estado_ruta') == 'Abierta' ? 'selected' : '' }}>Abierta</option>
                                <option value="Cerrada" {{ old('estado_ruta') == 'Cerrada' ? 'selected' : '' }}>Cerrada</option>
                            </select>
                            @error('estado_ruta')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Campo para las Recomendaciones --}}
                        <div class="form-group">
                            <label for="recomendaciones">Recomendaciones</label>
                            <textarea class="form-control @error('recomendaciones') is-invalid @enderror" id="recomendaciones" name="recomendaciones" rows="3" required>{{ old('recomendaciones') }}</textarea>
                            @error('recomendaciones')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="card-footer text-right">
                        <a href="{{ route('acceso.pantalla') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Acceso</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop