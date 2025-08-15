@extends('adminlte::page')

@section('title', 'Logins')

@section('content_header')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Listado de Logins</h1>
    <a href="{{ url('/personas-inicio') }}" class="btn btn-secondary">
        <i class="fas fa-home"></i> Regresar al menú de Personas
    </a>
</div>
<div class="d-flex justify-content-between align-items-center mb-3">
    <button class="btn btn-primary btn-sm"
            data-toggle="modal"
            data-target="#modalCrearLogin"
            onclick="resetCrearLogin()">
        <i class="fas fa-plus"></i> Agregar Login
    </button>
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table id="tabla-logins" class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Login</th>
                        <th>IP Usuario</th>
                        <th>Navegador</th>
                        <th>Éxito</th>
                        <th>Cod Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logins as $l)
                        <tr>
                            <td>{{ $l['cod_login'] ?? '' }}</td>
                            <td>{{ $l['fecha_login'] ?? '' }}</td>
                            <td>{{ $l['ip_usuario'] ?? '' }}</td>
                            <td>{{ $l['navegador'] ?? '' }}</td>
                            <td>{{ ($l['exito_login'] ?? false) ? 'Sí' : 'No' }}</td>
                            <td>{{ $l['cod_usuario'] ?? '' }}</td>
                            <td>
                                <form action="{{ route('logins.destroy', $l['cod_login'] ?? 0) }}" method="POST" style="display:inline-block;"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este login? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay logins registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL CREAR --}}
<div class="modal fade" id="modalCrearLogin" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('logins.store') }}" id="formCrearLogin">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar nuevo login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Fecha Login</label>
                        <input type="datetime-local" name="fecha_login" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>IP Usuario</label>
                        <input type="text" name="ip_usuario" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Navegador</label>
                        <input type="text" name="navegador" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Éxito</label>
                        <select name="exito_login" class="form-control" required>
                            <option value="1">Sí</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Código Usuario</label>
                        <input type="number" name="cod_usuario" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    $(function(){ $('#tabla-logins').DataTable(); });
    function resetCrearLogin() {
        const f = document.getElementById('formCrearLogin');
        if (f) f.reset();
    }
</script>
@stop
