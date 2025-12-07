<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-5">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-10 mx-auto">
        </div>

        <div class="bg-white p-12 rounded-3xl shadow-2xl">
            <h1 class="text-2xl font-bold text-center text-[#2128A5] mb-4">
                Restablecer contraseña
            </h1>

            <p class="text-center text-gray-600 mb-4">
                Por favor establece tu nueva contraseña.
            </p>

            <form method="POST" action="/reset-password" class="space-y-6">
                @csrf

                <!-- NUEVA CONTRASEÑA -->
                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Nueva contraseña *
                    </label>
                    <input type="password" id="new_password" name="password" required placeholder="Escribe tu nueva contraseña"
                           class="text-xs w-full px-5 py-2 border-2 border-[#2128A5] rounded-xl pr-14 bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300">
                    <button type="button" onclick="togglePassword('new_password', 'eye1')"
                            class="absolute right-4 top-11 text-gray-600">
                        <i id="eye1" class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Confirmar contraseña *
                    </label>
                    <input type="password" id="confirm_password" name="password_confirmation" required placeholder="Vuelve a escribir tu nueva contraseña"
                           class="text-xs w-full px-5 py-2 border-2 border-[#2128A5] rounded-xl pr-14 bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300">
                    <button type="button" onclick="togglePassword('confirm_password', 'eye2')"
                            class="absolute right-4 top-11 text-gray-600">
                        <i id="eye2" class="fa-solid fa-eye"></i>
                    </button>
                </div>

            <div class="flex justify-center">            
                <button type="submit"
                        class="w-auto px-8 bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-3 px-10 rounded-xl text-base transition">
                    Guardar Contraseña
                </button>
            </div>
            </form>

            <p class="text-center text-sm text-[#7072BF] mt-6">
                <a href="/login" class="no-underline hover:text-[#2128A5]">Volver al inicio de sesión</a>
            </p>
        </div>

        <p class="text-left text-xs text-[#7072BF] mt-5">
            Powered by Nexus © 2025
        </p>
    </div>

    <script>
    function togglePassword(id, iconId) {
        const input = document.getElementById(id);
        const icon = document.getElementById(iconId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
    </script>
</body>
</html>