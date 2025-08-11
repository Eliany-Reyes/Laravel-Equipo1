@extends('adminlte::page')

@section('title', 'Editar Bosque')

@section('content_header')
    <h1>Editar Bosque</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('bosques.update', $bosques['cod_bosque']) }}" method="POST">
                @csrf
                @method('PUT')


                <div class="form-group">
                    <label for="nombre_bosque">Nombre bosque</label>
                    <input type="text" name="nombre_bosque" class="form-control" value="{{ $bosques['nombre_bosque'] }}" required>
                </div>

                <div class="form-group">
                    <label for="departamento">Departamento</label>
                    <input type="text" name="departamento" class="form-control" value="{{ $bosques['departamento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="tipo_bosque">Tipo Bosque</label>
                    <input type="text" name="tipo_bosque" class="form-control" value="{{ $bosques['tipo_bosque'] }}" required>
                </div>

                <div class="form-group">
                    <label for="descripcion_bosque">Cantidad Maxima</label>
                    <input type="text" name="descripcion_bosque" class="form-control" value="{{ $bosques['descripcion_bosque'] }}" required>
                </div>

                <div class="form-group">
                    <label for="estado_bosque">Estado</label>
                    <input type="text" name="estado_bosque" class="form-control" value="{{ $bosques['estado_bosque'] }}" required>
                </div>


                {{-- ... y así sucesivamente para todos los campos ... --}}

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('bosques.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop