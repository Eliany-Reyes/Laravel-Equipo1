@extends('adminlte::page')

@section('title', 'Insertar Evento')

@section('content_header')
<div class="container">
    <h2>Insertar Nueva Factura</h2>
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
                <form action="{{ route('factura.actualizar') }}" method="POST">
                    @csrf

                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cod_factura">Código de Factura</label>
                            <input type="text" class="form-control" id="cod_factura" name="cod_factura" required>
                        </div>
                        <div class="form-group">
                            <label for="cod_reserva">Código de Reserva</label>
                            <input type="text" class="form-control" id="cod_reserva" name="cod_reserva" required>
                        </div>
                        <div class="form-group">
                            <label for="precio_evento">Precio de Evento</label>
                            <input type="text" class="form-control" id="precio_evento" name="precio_evento" required>
                        </div>
                        <div class="form-group">
                            <label for="sub_Total">Sub Total</label>
                            <textarea class="form-control" id="sub_Total" name="sub_Total" rows="3" required></textarea>
                        </div>
                      
                        <div class="form-group">
                            <label for="isv">ISV </label>
                            <input type="number" class="form-control" id="isv" name="isv" required>
                        </div>
                        <div class="form-group">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" id="total" name="total">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Factura</button>
                        <a href="{{ route('factura.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop