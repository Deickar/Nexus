<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Nexus Ecommerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-10">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-16 mx-auto">
        </div>

        <div class="bg-white p-12 rounded-3xl shadow-2xl">
            <h1 class="text-2xl font-bold text-center text-[#2128A5] mb-8">
                ¿Olvidaste tu contraseña?
            </h1>

            <p class="text-center text-gray-600 mb-4">
                Ingresa tu correo y te enviaremos un enlace para crear una nueva contraseña.
            </p>

            <form method="POST" action="/forgot-password" class="space-y-3">
                @csrf
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Correo electrónico *
                    </label>

                <input type="email" name="email" required placeholder="tuemail@gmail.com"
                       class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">

            <div class="flex justify-center">
                <button type="submit"
                        class="w-auto px-8 bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-xl text-base transition">
                    Enviar correo
                </button>
            </div>
            </form>

            <p class="text-center text-sm text-[#7072BF] mt-6">
                <a href="/login" class="underline hover:text-[#2128A5]">Regresar al Inicio de Sesion</a>
            </p>
        </div>

        <p class="text-left text-xs text-[#7072BF] mt-4">
            Desarrollado por Nexus Ecommerce © 2025
        </p>
    </div>
</body>
</html>
