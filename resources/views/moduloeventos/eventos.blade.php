@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
<div class="container">
    <h1 style="text-align: center;">Listado de Eventos
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
        <a href="{{ route('eventos.create') }}" class="add-button"><i class="fa-solid fa-plus"></i></a>
    
    </h1>
</div>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0fdf4; /* Fondo verde muy claro */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
       .header h1 {
        font-size: 24px;
        color: #1f2937; /* Color de texto más oscuro para el título */
        margin: 0;
        }
        .add-button {
         background-color: #16a34a; /* Azul para el botón */
        color: white;
        border: none;
        padding: 10px 12px; /* Reducido el padding para que sea más cuadrado */
        border-radius: 5px;
        font-size: 18px; /* Tamaño del ícono */
        cursor: pointer;
        transition: background-color 0.3s;
        }
        .add-button:hover {
        background-color: #15803d; /* Un azul más oscuro al pasar el ratón */
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #d1fae5; /* Encabezado de la tabla en un verde claro */
            color: #1f2937;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif; /* Aquí se cambia la fuente */
        }
        tr:nth-child(even) {
            background-color: #f9fafb; /* Color de fondo para filas pares */
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .edit-button, .delete-button {
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .edit-button {
            background-color: #f59e0b; /* Botón de editar en color amarillo */
        }
        .edit-button:hover {
            background-color: #d97706;
        }
        .delete-button {
            background-color: #ef4444; /* Botón de eliminar en color rojo */
        }
        .delete-button:hover {
            background-color: #dc2626;
        }
    </style>
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
                <div class="d-flex align-items-center">
                    <a href="{{ route('moduloeventos.menu') }}" class="btn btn-success mr-2">
                        <i class="fas fa-home"></i>
                    </a>
                      
                </div>
                

                <div class="card-body">
                    <table id="tabla-eventos" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Cod Evento</th>
                                <th>Cod Bosque</th>
                                <th>Tipo de Evento</th>
                                <th>Descripcion Evento</th>
                                <th>Precio Evento</th>
                                <th>Cantidad Maxima </th>
                                <th>Restricciones </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                            <tr>
                                <td>{{ $evento['cod_evento'] }}</td>
                                <td>{{ $evento['cod_bosque'] }}</td>
                                <td>{{ $evento['tipo_evento'] }}</td>
                                <td>{{ $evento['descripcion_evento'] }}</td>
                                <td>{{ $evento['precio_evento'] }}</td>
                                <td>{{ $evento['cantidad_maxima'] }}</td>
                                <td>{{ $evento['restricciones'] }}</td>
                                <td>
                                    <a href="{{ route('eventos.edit', $evento['cod_evento']) }}" class="btn btn-warning btn-sm">
                                        <div class="option-icon">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        </div>
                                        
                                    
                                    </a>

                                    <form action="{{ route('eventos.destroy', $evento['cod_evento']) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Eliminar" onclick="return confirm('¿Estás seguro de que quieres eliminar este evento?');">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                        
                                </td>
                            </tr>
                            @endforeach
                            @if(empty($eventos))
                                <tr>
                                    <td colspan="7" class="text-center">No hay eventos registrados.</td>
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
        $('#tabla-eventos').DataTable();

    });
</script>
@stop