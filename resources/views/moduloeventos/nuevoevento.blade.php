@extends('adminlte::page')

@section('title', 'Insertar Evento')

@section('content_header')
<div class="container">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Inserte un nuevo Evento</h3>
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
                            <input type="int"  class="form-control" id="precio_evento" name="precio_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="cantidad_maxima">Cantidad Máxima</label>
                            <input type="int" class="form-control" id="cantidad_maxima" name="cantidad_maxima" required>
                        </div>
                        <div class="form-group">
                            <label for="restricciones">Restricciones</label>
                            <input type="text" class="form-control" id="restricciones" name="restricciones">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i></button>

                    <a href="{{ route('eventos.index') }}" class="btn btn-danger">Cancelar</a>
                   </div>

                   
                </form>
            </div>
        </div>
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

      .card {
        max-width: 600px; /* Ajusta este valor si quieres un formulario más ancho o angosto */
    }
    .col-md-8 {
        margin: 0 auto !important;
        float: none !important;
        max-width: 600px; /* Opcional: Define un ancho máximo para que no se vea demasiado ancho en pantallas grandes */
    }

    /* Puedes mantener los estilos para centrar el contenido de la tarjeta */
    .card-header .card-title {
        text-align: center;
        width: 100%;
    }

</style>