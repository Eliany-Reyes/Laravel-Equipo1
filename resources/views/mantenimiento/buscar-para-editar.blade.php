@extends('adminlte::page')
@section('title', 'Buscar Mantenimiento para Editar')

@section('content_header')
    <div class="container">
        <h2>Buscar Mantenimiento para Editar</h2>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{-- Este formulario postea a la nueva ruta para buscar el mantenimiento --}}
                        <form action="{{ route('mantenimientos.fetch') }}" method="POST">
                            @csrf
                            
                            <div class="form-group">
                                <label for="cod_mantenimiento">Ingrese el Código de Mantenimiento a Editar</label>
                                <input type="text" class="form-control" id="cod_mantenimiento" name="cod_mantenimiento" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Buscar Mantenimiento</button>
                            <a href="{{ route('mantenimientos.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
