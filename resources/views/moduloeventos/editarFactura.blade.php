@extends('adminlte::page')

@section('title', 'Editar Factura')

@section('content_header')
    <h1 style="text-align: center;">Editar Factura</h1>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('factura.update', $facturas['cod_factura']) }}" method="POST">
                @csrf
                @method('PUT')

                

                <div class="form-group">
                    <label for="cod_reserva">Cod Reserva </label>
                    <input type="text" name="cod_reserva" class="form-control" value="{{ $facturas['cod_reserva'] }}" required>
                </div>

                <div class="form-group">
                    <label for="precio_evento">Precio de Evento</label>
                    <input type="text" name="precio_evento" class="form-control" value="{{ $facturas['precio_evento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="sub_Total">Sub Total</label>
                    <input type="text" name="sub_Total" class="form-control" value="{{ $facturas['sub_Total'] }}" required>
                </div>

                <div class="form-group">
                    <label for="isv">ISV</label>
                    <input type="text" name="isv" class="form-control" value="{{ $facturas['isv'] }}" required>
                </div>

                <div class="form-group">
                    <label for="total">Total</label>
                    <input type="text" name="total" class="form-control" value="{{ $facturas['total'] }}" required>
                </div>


                

                

                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i></button>
                    
                    <a href="{{ route('factura.index') }}" class="btn btn-danger">Cancelar</a>
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