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
            display: flex;
            justify-content: center;
            gap: 2rem;
            flex-wrap: wrap;
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
        .image-header {
            width: 90%;
            margin: 20px auto;
            overflow: hidden;
    
            /* Nuevos estilos para el borde redondeado y el color de fondo */
            background-color: #d1fae5; /* Un fondo verde muy claro */
            padding: 10px; /* Espacio entre el borde y la imagen */
            border-radius: 10px; /* Esquinas redondeadas */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave para un efecto 3D */
        }

        .image-header img {
            display: block;
            width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 200px;

             /* Asegura que la imagen tenga las mismas esquinas redondeadas */
            border-radius: 6px; 
        }

    </style>
</head>
<body>
   
    <div class="container">
        <div class="header">
            <a href="{{ route('home') }}" class="back-button">Regresar</a>
            <h1 class="title">MENÚ DE MÓDULOS</h1>
        </div>
         <div class="image-header">
        <img src="https://www.goldplast.com/dam/jcr:b820f3a5-32a9-4f19-a6de-44720bfedd0a/evento-en-plein-air.jpg" alt="esoo">
    </div>
        <div class="options-grid">
           
           <a href="{{ route('eventos.index') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <span class="option-text">VER EVENTOS </span>
            </a>

           
             <a href="{{ route('reserva.index') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                   <i class="fa-solid fa-champagne-glasses"></i>
                </div>
                <span class="option-text">VER RESERVAS </span>
            </a>

           
         <a href="{{ route('factura.index') }}" class="card p-4 flex flex-col items-center justify-center text-center">
                <div class="option-icon">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
                <span class="option-text">VER FACTURAS </span>
            </a>

           
          
        </div>
    </div>
</body>
</html>
