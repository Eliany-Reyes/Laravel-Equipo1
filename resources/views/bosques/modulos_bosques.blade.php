<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Módulos</title>
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
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            max-width: 900px;
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
            <a href="{{ route('home') }}" class="back-button">Regresar</a>
            <h1 class="title">MENÚ DE BOSQUES</h1>
        </div>
        <div class="options-grid">
            <!-- Opción para Módulo de Bosques -->
           <a href="{{ route('bosques.pantalla') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fas fa-tree"></i>
                </div>
                <span class="option-text">VER BOSQUES </span>
            </a>

            <!-- Opción para Módulo de Actividades -->
             <a href="{{ route('actividades.pantalla') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fas fa-running"></i>
                </div>
                <span class="option-text">VER ACTIVIDADES </span>
            </a>

            <!-- Opción para Módulo de Acceso -->
         <a href="{{ route('acceso.pantalla') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fas fa-door-open"></i>
                </div>
                <span class="option-text">VER ACCESO </span>
            </a>

            <!-- Opción para Módulo de Flora y Fauna -->
           <a href="{{ route('bosques.florafauna') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fas fa-paw"></i>
                </div>
                <span class="option-text">VER FLORA Y FAUNA </span>
            </a>
        </div>
    </div>
</body>
</html>
