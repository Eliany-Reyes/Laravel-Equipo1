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
                <p>Gestión de respaldos del sistema.</p>
                <a href="{{ route('backups.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>

    <!-- Clientes -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Clientes</div>
            <div class="card-body">
                <i class="fas fa-users fa-3x mb-3"></i>
                <p>Administración de información de clientes.</p>
                {{-- Ajusta esta ruta si tu índice de clientes se llama diferente --}}

                <a href="{{ route('clientes.index') }}" class="btn btn-primary">Abrir</a>

            </div>
        </div>
    </div>

    <!-- Correos -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Correos</div>
            <div class="card-body">
                <i class="fas fa-envelope fa-3x mb-3"></i>
                <p>Gestión de direcciones de correo electrónico.</p>
                {{-- Ajusta esta ruta si tu índice de correos se llama diferente --}}
                <a href="{{ route('correos.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4"> {{-- Nueva fila para los siguientes módulos --}}

    <!-- Direcciones -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Direcciones</div>
            <div class="card-body">
                <i class="fas fa-map-marker-alt fa-3x mb-3"></i>
                <p>Manejo de direcciones físicas.</p>
                {{-- Ajusta esta ruta si tu índice de direcciones se llama diferente --}}
                <a href="{{ route('direcciones.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>

    <!-- Empleados -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Empleados</div>
            <div class="card-body">
                <i class="fas fa-user-tie fa-3x mb-3"></i>
                <p>Información y gestión de empleados.</p>
                {{-- Ajusta esta ruta si tu índice de empleados se llama diferente --}}
                <a href="{{ route('empleados.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>

    <!-- Empleado – Rol -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Empleado – Rol</div>
            <div class="card-body">
                <i class="fas fa-id-badge fa-3x mb-3"></i>
                <p>Asignaciones de roles para empleados.</p>
                {{-- Ajusta esta ruta al que ya tengas --}}
                <a href="{{ route('empleadorol.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>

</div>

<div class="row mt-4"> {{-- Nueva fila para el último módulo --}}

    <!-- Logins -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-header">Logins</div>
            <div class="card-body">
                <i class="fas fa-sign-in-alt fa-3x mb-3"></i>
                <p>Historial y gestión de accesos al sistema.</p>
                {{-- Ajusta este route si tu índice de logins se llama diferente --}}
                <a href="{{ route('logins.index') }}" class="btn btn-primary">Abrir</a>
            </div>
        </div>
    </div>
<div class="col-md-4">
    <div class="card text-center">
        <div class="card-header">Pantallas</div>
        <div class="card-body">
            <i class="fas fa-desktop fa-3x mb-3"></i>
            <p>Historial y gestión de accesos al sistema.</p>
            {{-- Ajusta este route si tu índice de pantallas se llama diferente --}}
            <a href="{{ route('pantallas.index') }}" class="btn btn-primary">Abrir</a>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card text-center">
        <div class="card-header">Roles</div>
        <div class="card-body">
            <i class="fas fa-user-tag fa-3x mb-3"></i>
            <p>Gestión de roles y niveles de acceso del sistema.</p>
            <a href="{{ route('roles.index') }}" class="btn btn-primary">Abrir</a>
        </div>
    </div>
</div>
<div class="row mt-4"> {{-- Nueva fila para el último módulo --}}
    
</div>
<div class="col-md-4">
    <div class="card text-center">
        <div class="card-header">Permisos</div>
        <div class="card-body">
            <i class="fas fa-lock fa-3x mb-3"></i>
            <p>Configuración de permisos de usuario por pantalla.</p>
            <a href="{{ route('permisos.index') }}" class="btn btn-primary">Abrir</a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card text-center">
        <div class="card-header">Usuarios</div>
        <div class="card-body">
            <i class="fas fa-user fa-3x mb-3"></i>
            <p>Gestión y administración de usuarios del sistema.</p>
            <a href="{{ route('usuarios.index') }}" class="btn btn-primary">Abrir</a>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card text-center">
        <div class="card-header">Teléfonos</div>
        <div class="card-body">
            <i class="fas fa-phone fa-3x mb-3"></i>
            <p>Gestión de información de contacto telefónico.</p>
            <a href="{{ route('telefonos.index') }}" class="btn btn-primary">Abrir</a>
        </div>
    </div>
</div>
@stop
