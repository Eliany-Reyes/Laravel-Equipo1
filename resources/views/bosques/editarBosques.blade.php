@extends('adminlte::page')

@section('title', 'Editar Bosque')

@section('content_header')
<div class="container-fluid text-center">
    <h2 class="font-weight-bold"><i class="fas fa-tree"></i> Editar Bosque</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Formulario de Edición</h3>
                </div>
                <form action="{{ route('bosques.update', $bosques['cod_bosque']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre_bosque">Nombre del Bosque</label>
                            <input type="text" class="form-control" id="nombre_bosque" name="nombre_bosque" value="{{ old('nombre_bosque', $bosques['nombre_bosque']) }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <option value="">Seleccione un departamento</option>
                                @php
                                    $departamentos = [
                                        'Atlántida', 'Choluteca', 'Colón', 'Comayagua', 'Copán', 'Cortés', 'El Paraíso',
                                        'Francisco Morazán', 'Gracias a Dios', 'Intibucá', 'Islas de la Bahía', 'La Paz',
                                        'Lempira', 'Ocotepeque', 'Olancho', 'Santa Bárbara', 'Valle', 'Yoro'
                                    ];
                                @endphp
                                @foreach($departamentos as $depto)
                                    <option value="{{ $depto }}" {{ old('departamento', $bosques['departamento']) == $depto ? 'selected' : '' }}>
                                        {{ $depto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="tipo_bosque">Tipo de Bosque</label>
                            <select class="form-control" id="tipo_bosque" name="tipo_bosque" required>
                                <option value="">Seleccione un tipo de bosque</option>
                                @php
                                    $tipos_bosque = [
                                        'Bosque Seco Tropical', 'Bosque Húmedo Tropical', 'Bosque de Pino-Roble', 
                                        'Bosque de Manglar', 'Bosque Nublado', 'Sabana de Pino', 'Selva de Lluvias'
                                    ];
                                @endphp
                                @foreach($tipos_bosque as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_bosque', $bosques['tipo_bosque']) == $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion_bosque">Descripción</label>
                            <textarea class="form-control" id="descripcion_bosque" name="descripcion_bosque" rows="3" required>{{ old('descripcion_bosque', $bosques['descripcion_bosque']) }}</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado_bosque">Estado</label>
                            <select class="form-control" id="estado_bosque" name="estado_bosque" required>
                                <option value="">Seleccione un estado</option>
                                <option value="Activo" {{ old('estado_bosque', $bosques['estado_bosque']) == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ old('estado_bosque', $bosques['estado_bosque']) == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="card-footer text-right">
                        <a href="{{ route('bosques.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- No se necesita CSS personalizado para este diseño --}}
@stop