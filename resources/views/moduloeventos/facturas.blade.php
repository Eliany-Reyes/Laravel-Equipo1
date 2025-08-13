@extends('adminlte::page')

@section('title', 'Facturas')

@section('content_header')
<div class="container">
    <h2 style="text-align: center;">Listado de Facturas
        <a href="{{ route('factura.create') }}" class="btn btn-primary ml-2">Insertar Nuevo</a>
    </h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
         @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif


        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Facturas</h3>
                </div>
                <div class="card-body">
                    <table id="tabla-facturas" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Factura</th>
                                <th>Cod Reserva</th>
                                <th>Precio Evento</th>
                                <th>Sub Total</th>
                                <th>ISV</th>
                                <th>Total </th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($facturas as $factura)
                            <tr>
                                <td>{{ $factura['cod_factura'] }}</td>
                                <td>{{ $factura['cod_reserva'] }}</td>
                                <td>{{ $factura['precio_evento'] }}</td>
                                <td>{{ $factura['sub_Total'] }}</td>
                                <td>{{ $factura['isv'] }}</td>
                                <td>{{ $factura['total'] }}</td>
                                <td>
                                    <a href="{{ route('factura.edit', $factura['cod_factura']) }}" class="btn btn-warning btn-sm">
                                        Editar
                                    </a>

                                    <form action="{{ route('factura.destroy', $factura['cod_factura']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento?');">
                                            <i class="fa fa-lg fa-fw fa-trash"></i>
                                        </button>
                                    </form>

                                </td>

                            </tr>
                            @endforeach
                            @if(empty($facturas))
                                <tr>
                                    <td colspan="6" class="text-center">No hay Facturas registrados.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    $(document).ready(function() {
        $('#tabla-facturas').DataTable();
    });
</script>
@stop