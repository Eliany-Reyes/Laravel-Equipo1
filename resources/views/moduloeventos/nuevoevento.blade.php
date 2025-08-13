@extends('adminlte::page')

@section('title', 'Insertar Evento')

@section('content_header')
<div class="container">
    <h2>Insertar Nuevo Evento</h2>
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
                <form action="{{ route('eventos.actualizar') }}" method="POST">
                    @csrf

                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cod_evento">Código de Evento</label>
                            <input type="text" class="form-control" id="cod_evento" name="cod_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="cod_bosque">Código de Bosque</label>
                            <input type="text" class="form-control" id="cod_bosque" name="cod_bosque" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_evento">Tipo de Evento</label>
                            <input type="text" class="form-control" id="tipo_evento" name="tipo_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_evento">Descripción</label>
                            <textarea class="form-control" id="descripcion_evento" name="descripcion_evento" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="precio_evento">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="precio_evento" name="precio_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad_maxima">Cantidad Máxima</label>
                            <input type="number" class="form-control" id="cantidad_maxima" name="cantidad_maxima" required>
                        </div>
                        <div class="form-group">
                            <label for="restricciones">Restricciones</label>
                            <input type="text" class="form-control" id="restricciones" name="restricciones">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Evento</button>
                        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop