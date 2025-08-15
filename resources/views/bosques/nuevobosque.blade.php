@extends('adminlte::page')

@section('title', 'Insertar Bosque')

@section('content_header')
<div class="container-fluid text-center">
    <h2>Insertar Nuevo Bosque</h2>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Formulario de Inserción</h3>
                </div>
                <form action="{{ route('bosques.store') }}" method="POST">
                    @csrf
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre_bosque">Nombre del Bosque</label>
                            <input type="text" class="form-control" id="nombre_bosque" name="nombre_bosque" required>
                        </div>
                        <div class="form-group">
                            <label for="departamento">Departamento</label>
                            <select class="form-control" id="departamento" name="departamento" required>
                                <option value="">Seleccione un departamento</option>
                                <option value="Atlántida">Atlántida</option>
                                <option value="Choluteca">Choluteca</option>
                                <option value="Colón">Colón</option>
                                <option value="Comayagua">Comayagua</option>
                                <option value="Copán">Copán</option>
                                <option value="Cortés">Cortés</option>
                                <option value="El Paraíso">El Paraíso</option>
                                <option value="Francisco Morazán">Francisco Morazán</option>
                                <option value="Gracias a Dios">Gracias a Dios</option>
                                <option value="Intibucá">Intibucá</option>
                                <option value="Islas de la Bahía">Islas de la Bahía</option>
                                <option value="La Paz">La Paz</option>
                                <option value="Lempira">Lempira</option>
                                <option value="Ocotepeque">Ocotepeque</option>
                                <option value="Olancho">Olancho</option>
                                <option value="Santa Bárbara">Santa Bárbara</option>
                                <option value="Valle">Valle</option>
                                <option value="Yoro">Yoro</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_bosque">Tipo de Bosque</label>
                            <input type="text" class="form-control" id="tipo_bosque" name="tipo_bosque" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion_bosque">Descripción</label>
                            <textarea class="form-control" id="descripcion_bosque" name="descripcion_bosque" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="estado_bosque">Estado</label>
                            <select class="form-control" id="estado_bosque" name="estado_bosque" required>
                                <option value="">Seleccione un estado</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">Guardar Bosque</button>
                        <a href="{{ route('bosques.pantalla') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
