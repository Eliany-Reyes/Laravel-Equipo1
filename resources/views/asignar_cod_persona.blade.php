<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignar Código de Persona</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .container {
            max-width: 500px;
            margin: auto;
            padding: 2rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="container">
        <h1 class="text-2xl font-bold mb-4 text-center">Asignar Código de Persona</h1>
        <p class="mb-6 text-gray-700 text-center">
            Se ha creado el usuario **{{ $user->nombre_usuario }}**. Por favor, asigne un código de persona para activarlo.
        </p>

        <form method="POST" action="{{ route('update.cod_persona', $user->cod_usuario) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="cod_persona" class="block text-gray-700 font-bold mb-2">Código de Persona</label>
                <input type="text" name="cod_persona" id="cod_persona" required
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @error('cod_persona')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-200">
                Asignar y Activar
            </button>
        </form>
    </div>

</body>
</html>