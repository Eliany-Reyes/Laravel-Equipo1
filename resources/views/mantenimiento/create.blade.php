@extends('adminlte::page')

@section('title', 'Crear Mantenimiento')

@section('content_header')
    <h1>Crear Mantenimiento</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('mantenimientos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="tipo_mantenimiento">Tipo de Mantenimiento</label>
                    <input type="text" name="tipo_mantenimiento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha_programada">Fecha Programada</label>
                    <input type="datetime-local" name="fecha_programada" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea name="descripcion" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="materiales">Materiales</label>
                    <input type="text" name="materiales" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" class="form-control" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="En Progreso">En Progreso</option>
                        <option value="Completado">Completado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Regresar</a>
            </form>
        </div>
    </div>
@stop