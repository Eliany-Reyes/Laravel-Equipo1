<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulos de Mantenimiento</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Se ha reemplazado el color de fondo por una imagen */
            background-image: url("{{ asset('fondo-modulos.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Mantiene la imagen fija al hacer scroll */
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            /* Se cambió el color del fondo del contenedor a un blanco con 80% de opacidad.
            Esto permite que la imagen del body se vea un poco a través del contenedor.
            Si quieres un color sólido, simplemente usa un código hexadecimal como '#ffffff'. */
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .back-button {
            padding: 0.5rem 1rem;
            /* Se ha cambiado el color de fondo del botón a un verde más oscuro */
            background-color: #16a34a;
            color: #ffffff;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .back-button:hover {
            /* Se ha cambiado el color de fondo del botón al pasar el mouse a un verde más oscuro */
            background-color: #15803d;
        }
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            text-align: center;
            flex-grow: 1;
        }
        .image-box {
            background-color: #93c5fd;
            height: 200px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }
        .image-box img {
            max-height: 100%;
            width: 100%;
            /* Se ha cambiado de nuevo a 'cover' para que la imagen se adapte al ancho del recuadro */
            object-fit: cover;
            border-radius: 12px;
        }
        .options-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            text-align: center;
        }
        .option {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #4b5563;
            transition: transform 0.2s;
        }
        .option:hover {
            transform: translateY(-5px);
        }
        .option-icon {
            width: 80px;
            height: 80px;
            border-radius: 9999px;
            /* Se ha cambiado el color de fondo del círculo a un verde un poco más oscuro */
            background-color: #86efac;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            /* Se ha cambiado el color del ícono de Font Awesome a un verde más oscuro */
            color: #15803d;
            margin-bottom: 0.5rem;
        }
        .option-text {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.875rem;
        }
        @media (max-width: 600px) {
            .options-grid {
                grid-template-columns: 1fr;
            }
            .title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Botón de regresar que te lleva a la página principal -->
            <a href="{{ route('home') }}" class="back-button">Regresar</a>
            <h1 class="title">MÓDULOS DE MANTENIMIENTO PREVENTIVOS DE BOSQUES</h1>
            <!-- Espacio para mantener el centrado del título -->
            <div style="width: 100px;"></div>
        </div>

        <!-- Contenedor para la imagen -->
        <div class="image-box">
            <!-- La ruta de la imagen se ha actualizado a 'mant.png' -->
            <img src="{{ asset('mant.png') }}" alt="Imagen del Bosque">
        </div>

        <!-- Título de las áreas disponibles -->
        <h2 class="text-xl font-semibold text-center mb-6">ÁREAS DISPONIBLES</h2>
        
        <!-- Cuadrícula para las opciones de mantenimiento -->
        <div class="options-grid">
            <!-- Opción para Ver Mantenimientos -->
            <a href="{{ route('mantenimientos.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <span class="option-text">Ver Mantenimientos</span>
            </a>

            <!-- Opción para Insertar Mantenimiento -->
            <a href="{{ route('mantenimientos.create') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span class="option-text">Insertar Mantenimiento</span>
            </a>

            <!-- Opción para Actualizar Mantenimientos (redirige al listado) -->
            <a href="{{ route('mantenimientos.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <span class="option-text">Actualizar Mantenimientos</span>
            </a>

            <!-- Opción para Eliminar Mantenimientos (redirige al listado) -->
            <a href="{{ route('mantenimientos.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <span class="option-text">Eliminar Mantenimientos</span>
            </a>
        </div>
    </div>
</body>
</html>

