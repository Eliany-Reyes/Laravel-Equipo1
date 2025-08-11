<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulos de Bosques Forestales</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
       
        body {
            /* Agregamos la imagen de fondo */
            background-image: url("{{ asset('fondo_menu.png') }}"); 
            background-size: cover; /* Cubre todo el fondo */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* Evita que la imagen se repita */

            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s ease;
        }

       .header-bg, .card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 1rem;
            background-color: rgba(39, 133, 70, 0.62);
            backdrop-filter: blur(5px);
            border: 2px solid transparent;
        }

       .card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 0 15px rgba(0, 100, 0, 0.7); 
            border-color: rgba(5, 161, 5, 0.74);
        }

        .card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.9;
            transition: opacity 0.2s ease;
            border: 2px solid rgba(0, 128, 0, 0.3);
            border-radius: 0.5rem;
        }

        .card:hover .card-image {
            opacity: 1;
        }
    </style>
</head>
<body class="min-h-screen p-8">

    <header class="flex justify-between items-center mb-10 pb-4 border-b border-gray-600">
        <div class="flex-1 text-center">
            <h1 class="text-4xl font-bold text-white tracking-wider">MÓDULOS DE BOSQUES FORESTALES</h1>
        </div>
        <form action="{{ route('logout') }}" method="POST" class="ml-auto">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200 shadow-md">
                SALIR
            </button>
        </form>
    </header>

    <main class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-4">
        <a href="#" class="card p-4 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('personas.png') }}" alt="Personas" class="card-image w-48 h-48 mb-4">
            <h2 class="text-2xl font-semibold">PERSONAS</h2>
        </a>

        <a href="#" class="card p-4 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('eventos.png') }}" alt="Eventos" class="card-image w-48 h-48 mb-4">
            <h2 class="text-2xl font-semibold">EVENTOS</h2>
        </a>

        <a href="#" class="card p-4 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('visitas.png') }}" alt="Visitas" class="card-image w-48 h-48 mb-4">
            <h2 class="text-2xl font-semibold">VISITAS</h2>
        </a>

        <a href="{{ route('mantenimientos.index_pantalla') }}" class="card p-4 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('mantenimiento.png') }}" alt="Mantenimiento" class="card-image w-48 h-48 mb-4">
            <h2 class="text-2xl font-semibold">MANTENIMIENTO</h2>
        </a>

        <a href="#" class="card p-4 flex flex-col items-center justify-center text-center">
        <img src="{{ asset('localizar.png') }}" alt="Geolocalización" class="card-image w-48 h-48 mb-4">
        <h2 class="text-2xl font-semibold">GEOLOCALIZACIÓN</h2>
        </a>

        <!-- Se ha corregido el código eliminando la etiqueta 'a' anidada -->
        <a href="{{ route('bosques.menu') }}" class="card p-4 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('bosques.png') }}" alt="Bosques" class="card-image w-48 h-48 mb-4">
            <h2 class="text-2xl font-semibold">BOSQUES</h2>
        </a>
    </main>

</body>
</html>
