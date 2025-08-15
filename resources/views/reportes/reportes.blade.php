<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reportes</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 1100px;
            margin: auto;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            background-color: #e0f7fa;
            color: #00796b;
        }
        .error {
            background-color: #ffcdd2;
            color: #c62828;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            cursor: pointer;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        form {
            margin-top: 40px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        label {
            font-weight: bold;
        }
        button {
            padding: 10px 20px;
            background-color: #00796b;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #004d40;
        }
        /* Estilo del botón regresar */
        .btn-secondary {
            display: inline-block;
            padding: 8px 15px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Botón Regresar al Home -->
        <div style="text-align:right; margin-bottom:15px;">
            <a href="{{ url('/home') }}" class="btn-secondary">
                <i class="fas fa-home"></i> Regresar al Home
            </a>
        </div>

        <h1>Lista de Reportes</h1>

        @if(session('success'))
            <div class="message">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="message error">{{ session('error') }}</div>
        @elseif(isset($message))
            <div class="message">{{ $message }}</div>
        @endif

        @if(count($reportes) > 0)
            <table id="tabla-reportes">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Generado Por</th>
                        <th>Descripción</th>
                        <th>Código Gráfico</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportes as $reporte)
                        <tr 
                            data-id="{{ $reporte['cod_reporte'] ?? '' }}"
                            data-titulo="{{ $reporte['titulo'] ?? '' }}"
                            data-tipo="{{ $reporte['tipo_reporte'] ?? '' }}"
                            data-generado="{{ $reporte['generado_por'] ?? '' }}"
                            data-descripcion="{{ $reporte['descripcion'] ?? '' }}"
                            data-codgrafico="{{ $reporte['cod_grafico'] ?? '' }}"
                        >
                            <td>{{ $reporte['cod_reporte'] ?? 'N/A' }}</td>
                            <td>{{ $reporte['titulo'] ?? 'N/A' }}</td>
                            <td>{{ $reporte['tipo_reporte'] ?? 'N/A' }}</td>
                            <td>{{ $reporte['generado_por'] ?? 'N/A' }}</td>
                            <td>{{ $reporte['descripcion'] ?? 'N/A' }}</td>
                            <td>{{ $reporte['cod_grafico'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="text-align:center; font-style: italic; margin-top:10px;">
                Haz clic en una fila para editar ese reporte.
            </p>
        @else
            <p>No hay reportes disponibles.</p>
        @endif

        <h2>Nuevo Reporte</h2>
        <form method="POST" action="{{ route('reportes.store') }}">
            @csrf
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" required>

            <label for="tipo_reporte">Tipo de Reporte:</label>
            <input type="text" name="tipo_reporte" required>

            <label for="generado_por">Generado por:</label>
            <input type="text" name="generado_por" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion"></textarea>

            <label for="cod_grafico">Código Gráfico:</label>
            <input type="number" name="cod_grafico" required>

            <button type="submit">Guardar Reporte</button>
        </form>

        <h2>Editar Reporte</h2>
        <form method="POST" id="form-editar" action="{{ route('reportes.update') }}">
            @csrf
            @method('PUT')

            <!-- Hidden input para enviar el cod_reporte real -->
            <input type="hidden" name="cod_reporte" id="edit-cod_reporte">

            <!-- Campo visible y editable para el código -->
            <label for="edit-cod_reporte_visible">Código de Reporte:</label>
            <input type="text" id="edit-cod_reporte_visible" style="background-color:#fff; cursor:text;">

            <label for="edit-titulo">Título:</label>
            <input type="text" name="titulo" id="edit-titulo" required>

            <label for="edit-tipo_reporte">Tipo de Reporte:</label>
            <input type="text" name="tipo_reporte" id="edit-tipo_reporte" required>

            <label for="edit-generado_por">Generado por:</label>
            <input type="text" name="generado_por" id="edit-generado_por" required>

            <label for="edit-descripcion">Descripción:</label>
            <textarea name="descripcion" id="edit-descripcion"></textarea>

            <label for="edit-cod_grafico">Código Gráfico:</label>
            <input type="number" name="cod_grafico" id="edit-cod_grafico" required>

            <button type="submit">Actualizar Reporte</button>
        </form>
    </div>

    <script>
        // Capturar click en fila y cargar formulario de editar
        document.querySelectorAll('#tabla-reportes tbody tr').forEach(row => {
            row.addEventListener('click', () => {
                const id = row.getAttribute('data-id');
                const titulo = row.getAttribute('data-titulo');
                const tipo = row.getAttribute('data-tipo');
                const generado = row.getAttribute('data-generado');
                const descripcion = row.getAttribute('data-descripcion');
                const codgrafico = row.getAttribute('data-codgrafico');

                document.getElementById('edit-cod_reporte').value = id;
                document.getElementById('edit-cod_reporte_visible').value = id;
                document.getElementById('edit-titulo').value = titulo;
                document.getElementById('edit-tipo_reporte').value = tipo;
                document.getElementById('edit-generado_por').value = generado;
                document.getElementById('edit-descripcion').value = descripcion;
                document.getElementById('edit-cod_grafico').value = codgrafico;

                // La acción del formulario es fija, no se usa id en URL
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            });
        });

        // Sincronizar el campo visible con el hidden para enviar cod_reporte correctamente
        document.getElementById('edit-cod_reporte_visible').addEventListener('input', function() {
            document.getElementById('edit-cod_reporte').value = this.value;
        });
    </script>
</body>
</html>
