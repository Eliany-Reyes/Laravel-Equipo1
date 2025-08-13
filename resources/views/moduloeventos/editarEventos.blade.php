@extends('adminlte::page')

@section('title', 'Editar Evento')

@section('content_header')
    <h1>Editar Evento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('eventos.update', $eventos['cod_evento']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="cod_bosque">Código de Bosque</label>
                    <input type="text" name="cod_bosque" class="form-control" value="{{ $eventos['cod_bosque'] }}" required>
                </div>

                <div class="form-group">
                    <label for="tipo_evento">Tipo de Evento</label>
                    <input type="text" name="tipo_evento" class="form-control" value="{{ $eventos['tipo_evento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion_evento">Descripcion de Evento</label>
                    <input type="text" name="descripcion_evento" class="form-control" value="{{ $eventos['descripcion_evento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="precio_evento">Precio de Evento</label>
                    <input type="text" name="precio_evento" class="form-control" value="{{ $eventos['precio_evento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="cantidad_maxima">Cantidad Maxima</label>
                    <input type="text" name="cantidad_maxima" class="form-control" value="{{ $eventos['cantidad_maxima'] }}" required>
                </div>

                <div class="form-group">
                    <label for="restricciones">Restricciones</label>
                    <input type="text" name="restricciones" class="form-control" value="{{ $eventos['restricciones'] }}" required>
                </div>


                {{-- ... y así sucesivamente para todos los campos ... --}}

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop