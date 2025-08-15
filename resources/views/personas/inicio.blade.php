@extends('adminlte::page')

@section('title', 'Personas – Submenú')

@section('content_header')
  <div class="d-flex justify-content-between align-items-center">
    <h1>Personas – Módulos</h1>
    <a href="{{ route('home') }}" class="btn btn-secondary">
      <i class="fas fa-home"></i> Volver al Home
    </a>
  </div>
@stop

@section('content')
<div class="row">

  <!-- Backups -->
  <div class="col-md-4">
    <div class="card text-center">
      <div class="card-header">Backups</div>
      <div class="card-body">
        <i class="fas fa-database fa-3x mb-3"></i>
        <p>Gestión de respaldos.</p>
        <a href="{{ route('backups.index') }}" class="btn btn-primary">Abrir</a>
      </div>
    </div>
  </div>

  <!-- Logins -->
  <div class="col-md-4">
    <div class="card text-center">
      <div class="card-header">Logins</div>
      <div class="card-body">
        <i class="fas fa-sign-in-alt fa-3x mb-3"></i>
        <p>Historial de accesos.</p>
        <!-- Ajusta este route si tu índice de logins se llama diferente -->
        <a href="{{ route('logins.index') }}" class="btn btn-primary">Abrir</a>
      </div>
    </div>
  </div>

  <!-- Empleado – Rol -->
  <div class="col-md-4">
    <div class="card text-center">
      <div class="card-header">Empleado – Rol</div>
      <div class="card-body">
        <i class="fas fa-id-badge fa-3x mb-3"></i>
        <p>Asignaciones de roles.</p>
        <!-- Ajusta este route al que ya tengas -->
        <a href="{{ route('empleadorol.index') }}" class="btn btn-primary">Abrir</a>
      </div>
    </div>
  </div>

</div>
@stop
