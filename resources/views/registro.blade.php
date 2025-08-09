<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }
        .login-content {
            position: relative;
            z-index: 2;
        }
        .login-card {
            background-color: rgba(255, 255, 255, 0.6);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2), 0 0 15px rgba(59, 130, 246, 0.7);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div id="background-container"></div>
    <div class="overlay"></div>

    <main class="flex-1 p-8 flex items-center justify-center login-content">
        <div class="login-card rounded-lg shadow-xl p-8 w-full max-w-sm relative">
            <h1 class="text-3xl font-bold text-gray-800">BOSQUES FORESTALES</h1>
            <p class="mt-4 text-gray-600 font-bold">Crear Cuenta</p>

            <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-6">
                @csrf

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-user-circle text-gray-400"></i>
                    </div>
                    <input id="nombre_usuario" name="nombre_usuario" type="text" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Nombre de Usuario" value="{{ old('nombre_usuario') }}">
                </div>
                @error('nombre_usuario')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                    <input id="correo_electronico" name="correo_electronico" type="email" required
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

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <input id="contrasena_confirmation" name="contrasena_confirmation" type="password" required
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Confirmar Contraseña">
                </div>
                @error('contrasena_confirmation')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <button type="submit"
                            class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                        Registrarse
                    </button>
                </div>
            </form>
            
            <p class="mt-4 text-center text-gray-600">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Iniciar Sesión</a>
            </p>
        </div>
    </main>

</body>
</html>