@extends('adminlte::page')

@section('title', 'Editar Reserva')

@section('content_header')
    <h1 style="text-align: center;">Editar Reserva</h1>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reserva.update', $reservas['cod_reserva']) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="cod_evento">Código de Evento</label>
                    <input type="text" name="cod_evento" class="form-control" value="{{ $reservas['cod_evento'] }}" required>
                </div>

                <div class="form-group">
                    <label for="cod_persona">Codigo de Persona</label>
                    <input type="text" name="cod_persona" class="form-control" value="{{ $reservas['cod_persona'] }}" required>
                </div>

                <div class="form-group">
                    <label for="hora_reserva">Hora Reserva</label>
                    <input type="datetime-local" name="hora_reserva" class="form-control" value="{{ $reservas['hora_reserva'] }}" required>
                </div>

                <div class="form-group">
                    <label for="dia_reserva">Dia de Reserva</label>
                    <input type="date" name="dia_reserva" class="form-control" value="{{ $reservas['dia_reserva'] }}" required>
                </div>

                <div class="form-group">
                    <label for="cant_persona">Cantidad Persona</label>
                    <input type="text" name="cant_persona" class="form-control" value="{{ $reservas['cant_persona'] }}" required>
                </div>

                <div class="form-group">
                    <label for="isv_reserva">ISV Reserva</label>
                    <input type="text" name="isv_reserva" class="form-control" value="{{ $reservas['isv_reserva'] }}" required>
                </div>

                <div class="form-group">
                    <label for="sub_total">Sub Total</label>
                    <input type="text" name="sub_total" class="form-control" value="{{ $reservas['sub_total'] }}" required>
                </div>


                

                <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i></button>

                    <a href="{{ route('reserva.index') }}" class="btn btn-danger">Cancelar</a>
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