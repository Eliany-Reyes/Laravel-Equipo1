@extends('adminlte::page')

@section('title', 'Editar Factura')

@section('content_header')
    <h1>Editar Factura</h1>
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


                {{-- ... y así sucesivamente para todos los campos ... --}}

                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('factura.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@stop