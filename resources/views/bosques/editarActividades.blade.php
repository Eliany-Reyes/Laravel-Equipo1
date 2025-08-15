@extends('adminlte::page')

@section('title', 'Editar Actividad')

@section('content_header')
    <h1>Editar Actividad</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Muestra mensajes de éxito o error si existen --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            {{-- Verificamos que la variable $actividad exista y contenga la clave 'cod_actividad' --}}
            @if(isset($actividad) && isset($actividad['cod_actividad']))
                <form action="{{ route('actividades.update', $actividad['cod_actividad']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Campo oculto para enviar el código del bosque, ya que la actividad pertenece a un bosque específico --}}
                    {{-- Usamos el helper old() para mantener el valor en caso de error de validación --}}
                    <input type="hidden" name="cod_bosque" value="{{ old('cod_bosque', $actividad['cod_bosque'] ?? '') }}">

                    <div class="form-group">
                        <label for="descripcion_actividad">Descripción de la Actividad</label>
                        {{-- Usamos el helper old() para mantener el valor en caso de error de validación --}}
                        <input type="text" name="descripcion_actividad" class="form-control" value="{{ old('descripcion_actividad', $actividad['descripcion_actividad'] ?? '') }}" required>
                        @error('descripcion_actividad')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="espacios_disponibles">Espacios Disponibles</label>
                        {{-- Usamos el helper old() para mantener el valor en caso de error de validación --}}
                        <input type="number" name="espacios_disponibles" class="form-control" value="{{ old('espacios_disponibles', $actividad['espacios_disponibles'] ?? '') }}" required>
                        @error('espacios_disponibles')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <a href="{{ route('actividades.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            @else
                {{-- Mensaje de error si los datos no están disponibles --}}
                <div class="alert alert-danger">
                    No se pudieron cargar los datos de la actividad para editar. Por favor, intente de nuevo.
                </div>
                <a href="{{ route('actividades.index') }}" class="btn btn-primary">Volver a la lista de actividades</a>
            @endif
        </div>
    </div>
@stop
