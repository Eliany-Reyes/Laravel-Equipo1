@extends('adminlte::page')
@section('title', 'Editar Mantenimiento')

@section('content_header')
    <div class="container">
        <h2>Editar Mantenimiento</h2>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- El formulario apunta a la ruta de actualización y simula el método PUT --}}
                        {{-- La ruta ahora se llama correctamente con el ID del mantenimiento --}}
                        <form action="{{ route('mantenimientos.update', $mantenimiento['cod_mantenimiento']) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="cod_mantenimiento">Cod Mantenimiento</label>
                                <input type="text" class="form-control" id="cod_mantenimiento" name="cod_mantenimiento" value="{{ $mantenimiento['cod_mantenimiento'] }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="cod_bosque">Cod Bosque</label>
                                <input type="text" class="form-control" id="cod_bosque" name="cod_bosque" value="{{ $mantenimiento['cod_bosque'] }}" required>
                            </div>

                            <div class="form-group">
                                <label for="tipo_mantenimiento">Tipo Mantenimiento</label>
                                <input type="text" class="form-control" id="tipo_mantenimiento" name="tipo_mantenimiento" value="{{ $mantenimiento['tipo_mantenimiento'] }}" required>
                            </div>

                            <div class="form-group">
                                <label for="fecha_mantenimiento">Fecha Mantenimiento</label>
                                <input type="date" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" value="{{ $mantenimiento['fecha_mantenimiento'] }}" required>
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                {{-- Se ha corregido el nombre del campo para que coincida con el backend --}}
                                <textarea class="form-control" id="descripcion" name="descripcion" required>{{ $mantenimiento['descripcion_Man'] }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="materiales">Materiales</label>
                                {{-- Se ha corregido el nombre del campo para que coincida con el backend --}}
                                <textarea class="form-control" id="materiales" name="materiales" required>{{ $mantenimiento['materiales_Man'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="estado_bosque">Estado Bosque</label>
                                {{-- Se ha corregido el nombre del campo para que coincida con el backend --}}
                                <input type="text" class="form-control" id="estado_bosque" name="estado_bosque" value="{{ $mantenimiento['estado_Bosque'] }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar Mantenimiento</button>
                            <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
