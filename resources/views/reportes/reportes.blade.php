<!-- resources/views/reportes.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Módulo de Reportes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>


<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <a href="{{ url('/home') }}" class="btn btn-secondary">
        <i class="fas fa-home"></i> Regresar al Home
    </a>
</div>
    <h1 class="mb-4">📋 Módulo de Reportes</h1>

    {{-- FORMULARIO PARA CREAR / ACTUALIZAR --}}
    <div class="card mb-4">
        <div class="card-header">Agregar / Editar Reporte</div>
        <div class="card-body">
            <form id="formReporte">
                @csrf
                <input type="hidden" id="id" name="id">

                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <button type="button" id="cancelarEdicion" class="btn btn-secondary d-none">Cancelar</button>
            </form>
        </div>
    </div>

    {{-- LISTA DE REPORTES --}}
    <div class="card">
        <div class="card-header">Lista de Reportes</div>
        <div class="card-body">
            <table class="table table-bordered" id="tablaReportes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Aquí se cargan dinámicamente los datos --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const tabla = document.querySelector("#tablaReportes tbody");
    const form = document.querySelector("#formReporte");
    const cancelarBtn = document.querySelector("#cancelarEdicion");

    let editando = false;
    let idEditar = null;

    // Cargar reportes desde la ruta JSON
    function cargarReportes() {
        fetch("{{ route('reportes.json') }}")
            .then(res => res.json())
            .then(data => {
                tabla.innerHTML = "";
                data.forEach(r => {
                    tabla.innerHTML += `
                        <tr>
                            <td>${r.id}</td>
                            <td>${r.titulo}</td>
                            <td>${r.descripcion}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editarReporte(${r.id}, '${r.titulo}', '${r.descripcion}')">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarReporte(${r.id})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            });
    }

    // Guardar o actualizar
    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const titulo = document.querySelector("#titulo").value;
        const descripcion = document.querySelector("#descripcion").value;

        if (editando) {
            fetch("{{ route('reportes.update') }}", {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ id: idEditar, titulo, descripcion })
            }).then(() => {
                cargarReportes();
                form.reset();
                editando = false;
                cancelarBtn.classList.add("d-none");
            });
        } else {
            fetch("{{ route('reportes.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ titulo, descripcion })
            }).then(() => {
                cargarReportes();
                form.reset();
            });
        }
    });

    // Editar
    window.editarReporte = function(id, titulo, descripcion) {
        document.querySelector("#titulo").value = titulo;
        document.querySelector("#descripcion").value = descripcion;
        idEditar = id;
        editando = true;
        cancelarBtn.classList.remove("d-none");
    }

    // Cancelar edición
    cancelarBtn.addEventListener("click", function() {
        form.reset();
        editando = false;
        cancelarBtn.classList.add("d-none");
    });

    // Eliminar
    window.eliminarReporte = function(id) {
        if (confirm("¿Seguro que quieres eliminar este reporte?")) {
            fetch(`/reportes/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                }
            }).then(() => cargarReportes());
        }
    }

    cargarReportes();
});
</script>

</body>
</html>
