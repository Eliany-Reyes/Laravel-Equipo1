@extends('adminlte::page')
@section('title', 'Personas')

@section('content_header')
<div class="container">
  <h2>Listado de Personas</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de Personas</h3>
        </div>
        <div class="card-body">
          <table id="tabla-personas" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Cod Persona</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Edad</th>
                <th>Peso</th>
                <th>Estado Civil</th>
                <th>Nacionalidad</th>
                <th>Fecha Nacimiento</th>
                <th>Genero</th>
                <th>Idioma</th>
              </tr>
            </thead>
            <tbody>
             @foreach($personas as $persona)
              <tr>
                <td>{{ $persona['cod_persona'] }}</td>
                <td>{{ $persona['nombre'] }}</td>
                <td>{{ $persona['apellido'] }}</td>
                <td>{{ $persona['edad'] }}</td>
                <td>{{ $persona['peso'] }}</td>
                <td>{{ $persona['estado_civil'] }}</td>
                <td>{{ $persona['nacionalidad'] }}</td>
                <td>{{ $persona['fecha_nacimiento'] }}</td>
                <td>{{ $persona['genero'] }}</td>
                <td>{{ $persona['idioma_persona'] }}</td>
              </tr>
              @endforeach
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
      $('#tabla-personas').DataTable();
  });
</script>
@stop
