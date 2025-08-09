@extends('adminlte::page')

@section('title', 'Usuarios') {{-- Título de la página actualizado --}}

@section('content_header')
<div class="container">
    <h2>Listado de Usuarios</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de Usuarios</h3>
                    {{-- No se añade el botón "Agregar Usuario" aquí para ser idéntico al base de personas sin ese botón --}}
                </div>
                <div class="card-body">
                    <table id="tabla-usuarios" class="table table-bordered table-striped"> {{-- ID cambiado y clases idénticas --}}
                        <thead>
                            <tr>
                                <th>Cod Usuario</th>
                                <th>Cod Persona</th>
                                <th>Nombre Usuario</th>
                                <th>Correo Electronico</th>
                                <th>Contrasena</th> {{-- Incluido según tu lista de campos, sin acento --}}
                                <th>Id Rol</th>
                                <th>Estado</th>
                                <th>Fecha Registro</th>
                                <th>Ultimo Acceso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario['cod_usuario'] }}</td>
                                <td>{{ $usuario['cod_persona'] }}</td>
                                <td>{{ $usuario['nombre_usuario'] }}</td>
                                <td>{{ $usuario['correo_electronico'] }}</td>
                                <td>{{ $usuario['contrasena'] }}</td> {{-- Accediendo al campo de contraseña --}}
                                <td>{{ $usuario['id_rol'] }}</td>
                                <td>{{ $usuario['estado'] }}</td>
                                <td>{{ $usuario['fecha_registro'] }}</td>
                                <td>{{ $usuario['ultimo_acceso'] }}</td>
                                {{-- No se añaden botones de acción para ser idéntico al base de personas sin acciones --}}
                            </tr>
                            @endforeach
                            {{-- Mensaje de "No hay usuarios" si la variable $usuarios está vacía --}}
                            @if(empty($usuarios))
                                <tr>
                                    <td colspan="9" class="text-center">No hay usuarios registrados.</td> {{-- Colspan ajustado al número de columnas --}}
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
        $('#tabla-usuarios').DataTable(); {{-- ID cambiado, sin opciones extra para ser idéntico al base --}}
    });
</script>
@stop