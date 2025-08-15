@extends('adminlte::page')

@section('title', 'Editar Evento')

@section('content_header')
    <h1 style="text-align: center;">Editar Evento</h1>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
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


                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i></button>
                    
                    <a href="{{ route('eventos.index') }}" class="btn btn-danger">Cancelar</a>
                </div>

                
            </form>
        </div>
    </div>
@stop

<style>
    /* Estilos existentes para el fondo y la página */
    body.sidebar-mini {
        background-color: #f0fdf4 !important;
    }
    .content-wrapper {
        background-color: #f0fdf4 !important;
    }
    
    /* Estilos para centrar los elementos del formulario */
    .form-group {
        display: flex; 
        flex-direction: column;
        align-items: center; 
    }
    
    .form-group label {
        text-align: center; /* Centra el texto de las etiquetas */
    }

    .form-control {
        max-width: 300px; /* Mantiene los campos de entrada más cortos */
        text-align: center; /* Centra el texto dentro de los campos */
    }

</style>