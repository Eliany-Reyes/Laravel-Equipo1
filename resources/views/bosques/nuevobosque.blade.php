@extends('adminlte::page')

@section('title', 'Insertar Bosque')

@section('content_header')
<div class="container">
    <h2>Insertar Nuevo Bosque</h2>
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
                {{-- La acción del formulario se ha actualizado a la ruta correcta --}}
                <form action="{{ route('bosques.store') }}" method="POST">
                    @csrf
                    
                    <div class="card-body">

                       

                        <div class="form-group">
                            <label for="nombre_bosque">Nombre del Bosque</label>
                            <input type="text" class="form-control" id="nombre_bosque" name="nombre_bosque" required>
                        </div>
                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <input type="text" class="form-control" id="departamento" name="departamento" required>
                        </div>
                        <div class="form-group">
                            <label for="tipo_bosque">Tipo de Bosque</label>
                            <input type="text" class="form-control" id="tipo_bosque" name="tipo_bosque" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_bosque">Descripción</label>
                            <textarea class="form-control" id="descripcion_bosque" name="descripcion_bosque" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado_bosque">Estado</label>
                            <input type="text" class="form-control" id="estado_bosque" name="estado_bosque" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Bosque</button>
                        <a href="{{ route('bosques.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
