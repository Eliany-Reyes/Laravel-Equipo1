@extends('adminlte::page')

@section('title', 'Insertar Reserva')

@section('content_header')
<div class="container">
    <h2>Insertar Nuevo Reserva</h2>
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
                <form action="{{ route('reserva.actualizar') }}" method="POST">
                    @csrf

                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cod_reserva">Código de Reserva</label>
                            <input type="text" class="form-control" id="cod_reserva" name="cod_reserva" required>
                        </div>
                        <div class="form-group">
                            <label for="cod_evento">Código de Evento</label>
                            <input type="text" class="form-control" id="cod_evento" name="cod_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="cod_persona">Código de Persona</label>
                            <input type="text" class="form-control" id="cod_persona" name="cod_persona" required>
                        </div>
                        <div class="form-group">
                            <label for="hora_reserva">Hora de reserva</label>
                            <input type="datetime-local" class="form-control" id="hora_reserva" name="hora_reserva" required>
                            
                        </div>
                        <div class="form-group">
                            <label for="dia_reserva">Dia de la reserva</label>
                            <input type="date" class="form-control" id="dia_reserva" name="dia_reserva" required>

                           
                        </div>
                        <div class="form-group">
                            <label for="cant_persona">Cantidad Persona</label>
                            <input type="number" class="form-control" id="cant_persona" name="cant_persona" required>
                        </div>
                        <div class="form-group">
                            <label for="isv_reserva">ISV Reserva</label>
                            <input type="text" class="form-control" id="isv_reserva" name="isv_reserva">
                        </div>

                        <div class="form-group">
                            <label for="sub_total">Sub Total Reserva</label>
                            <input type="text" class="form-control" id="sub_total" name="sub_total">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Reserva</button>
                        <a href="{{ route('reserva.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop