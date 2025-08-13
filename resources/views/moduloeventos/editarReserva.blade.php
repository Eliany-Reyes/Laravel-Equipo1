@extends('adminlte::page')

@section('title', 'Editar Reserva')

@section('content_header')
    <h1>Editar Reserva</h1>
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


                

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('reserva.index') }}" class="btn btn-secondary">Cancelar</a>
                
            </form>
        </div>
    </div>
@stop