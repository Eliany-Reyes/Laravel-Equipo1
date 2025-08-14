<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulos de Gestión de Actividades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url("{{ asset('fondo-modulos.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
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
            background-color: #16a34a;
            color: #ffffff;
            border-radius: 9999px;
            font-weight: 600;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .back-button:hover {
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
            background-color: #86efac;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #15803d;
            margin-bottom: 0.5rem;
        }
        .option-text {
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.875rem;
            color: #1f2937;
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
            <a href="{{ route('bosques.menu') }}" class="back-button">Regresar</a>
            <h1 class="title">MÓDULOS DE GESTIÓN DE ACTIVIDADES</h1>
            <div style="width: 100px;"></div>
        </div>

        <div class="image-box">
            <img src="{{ asset('actividades.jpg') }}" alt="Imagen del Bosque">
        </div>

        <h2 class="text-xl font-semibold text-center mb-6">OPCIONES DISPONIBLES</h2>

        <div class="options-grid">
            <a href="{{ route('actividades.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-eye"></i>
                </div>
                <span class="option-text">Ver Actividades</span>
            </a>

            <a href="{{ route('actividades.create') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-plus"></i>
                </div>
                <span class="option-text">Insertar Actividad</span>
            </a>

            <a href="{{ route('actividades.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <span class="option-text">Actualizar Actividades</span>
            </a>

            <a href="{{ route('actividades.index') }}" class="option">
                <div class="option-icon">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <span class="option-text">Eliminar Actividades</span>
            </a>
        </div>
    </div>
</body>
</html>