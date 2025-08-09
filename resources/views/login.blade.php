<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #334155;
            position: relative;
        }

        /* Contenedor del fondo estático */
        #background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("{{ asset('fondo horizontal.png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Capa semi-transparente sobre la imagen */
            z-index: 1;
        }
        .login-content {
            position: relative;
            z-index: 2;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.6); /* Tarjeta de login más transparente */
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .login-card:hover {
            transform: translateY(-5px); /* Se mueve 5px hacia arriba */
            /* Agrega un segundo box-shadow para el efecto de resplandor */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 0 15px rgba(59, 130, 246, 0.7);
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none; /* Oculto por defecto */
            align-items: center;
            justify-content: center;
            z-index: 50;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div id="background-container"></div>
    <div class="overlay"></div>

    <main class="flex-1 p-8 flex items-center justify-center login-content">
        <div class="login-card rounded-lg shadow-xl p-8 w-full max-w-sm relative">
            <h1 class="text-3xl font-bold text-gray-800">BOSQUES FORESTALES</h1>
            <p class="mt-4 text-gray-600 font-bold">Iniciar Sesión</p>

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-6">
                @csrf

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                    <input id="correo_electronico" name="correo_electronico" type="text" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Correo Electrónico" value="{{ old('correo_electronico') }}">
                </div>
                @error('correo_electronico')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="contrasena" name="contrasena" type="password" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Contraseña">
                </div>
                @error('contrasena')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                            class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                        Iniciar Sesión
                    </button>
                </div>
            </form>
            </div>
    </main>

    <div id="errorModal" class="modal-overlay">
        <div class="modal-content">
            <p id="modalMessage" class="text-lg font-semibold text-red-600 mb-4">
                </p>
            <p class="mb-6 text-gray-700">¿Desea crear un usuario?</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('register') }}" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                    Crear Usuario
                </a>
                <a href="#" onclick="hideModal()" class="py-2 px-4 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg transition duration-200">
                    Salir
                </a>
            </div>
        </div>
    </div>

    <script>
        // Función para mostrar el modal con un mensaje dinámico
        function showModal(message) {
            document.getElementById('modalMessage').textContent = message;
            document.getElementById('errorModal').style.display = 'flex';
        }

        // Función para ocultar el modal
        function hideModal() {
            document.getElementById('errorModal').style.display = 'none';
        }

        // Comprueba si hay errores y muestra el modal con el primer error
        @if($errors->any())
            const errorMessage = "{{ $errors->first('correo_electronico') }}";
            if (errorMessage) {
                showModal(errorMessage);
            }
        @endif
    </script>
</body>
</html>