<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <!-- LOGIN -->
    <div class="w-full max-w-xs"> 

        <div class="text-center my-3">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-8 mx-auto">
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-2xl">

            <h1 class="text-xl font-bold text-center text-[#2128A5] mb-2">
                Crear una Cuenta
            </h1>

            <p class="text-center text-xs text-[#7072BF] mb-4">
                Si eres nuevo en nuestra tienda nos alegra tenerte como miembro.
            </p>

            <form method="POST" action="/register" class="space-y-3">  

                @csrf

                <!-- PRIMER NOMBRE -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Primer Nombre : *
                    </label>
                    <input type="text" name="name" required placeholder="Felipe"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                </div>

                <!-- APELLIDO -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Apellido : *
                    </label>
                    <input type="text" name="apellido" required placeholder="Esquivel"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                </div>

                <!-- CORREO -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Correo Electronico : *
                    </label>
                    <input type="email" name="email" required placeholder="tucorreo@example.com"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                </div>

                <!-- CONTRASEÑA + OJITO -->
                <div class="text-center relative">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Contraseña : *
                    </label>
                    <input type="password" id="password" name="password" required placeholder=""
                           class="w-full max-w-xs px-6 py-1.5 pr-10 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <button type="button" onclick="togglePassword('password', 'eye1')"
                            class="absolute right-4 top-5 text-gray-600 hover:text-gray-800">
                        <i id="eye1" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>

                <!-- CONFIRMAR CONTRASEÑA + OJITO -->
                <div class="text-center relative">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Confirmar Contraseña : *
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required placeholder=""
                           class="w-full max-w-xs px-6 py-1.5 pr-10 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye2')"
                            class="absolute right-4 top-5 text-gray-600 hover:text-gray-800">
                        <i id="eye2" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>

                <!-- CHECKBOX -->
                <div class="flex items-center justify-center mt-3">
                    <label class="flex items-center cursor-pointer text-xs text-[#7072BF]">
                        <input type="checkbox" class="hidden peer" required>
                        <div class="w-4 h-4 border-2 border-[#2128A5] rounded mr-2 peer-checked:bg-[#2128A5] transition flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        Acepto los terminos y condiciones. Haga click aqui
                    </label>
                </div>

                <!-- BOTÓN -->
                <div class="text-center mt-4">
                    <button type="submit"
                            class="bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-2 px-14 rounded-xl text-base transition">
                        Registrar
                    </button>
                </div>
            </form>

            <p class="text-left text-xs text-[#7072BF] mt-4">
                <a href="/login" class="no-underline hover:text-[#2128A5]">Ya tienes cuenta? Iniciar Sesion</a>
            </p>
        </div>

        <p class="text-left text-xs text-[#7072BF] mt-2">
            Powered by Nexus © 2025
        </p>
    </div>

    <!-- SCRIPT PARA LOS DOS OJITOS -->
    <script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
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