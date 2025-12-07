{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nexus</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome para el ojito --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <!-- LOGO -->
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-12 mx-auto">
        </div>

        <!-- LOGIN-->
        <div class="bg-white p-12 rounded-2xl shadow-2xl shadow-2xl">
            <h1 class="text-3xl font-bold text-center text-[#2128A5] mb-8">
                Inicio de Sesión
            </h1>

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Correo electrónico *
                    </label>
                    <input type="email" name="email" required placeholder="tuemail@gmail.com"
                           class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">
                </div>

                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Contraseña *
                    </label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl pr-14 bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">
                    
                    <!-- OJITO  -->
                    <button type="button" onclick="togglePassword()"
                            class="absolute right-4 top-11 text-gray-600 hover:text-gray-900">
                        <i id="eyeIcon" class="fa-solid fa-eye text-xl"></i>
                    </button>
                </div>


                <!-- ==================== OLVIDÉ CONTRASEÑA ==================== -->
                <div class="text-left">
                    <a href="/password" class="text-xs text-[#7072BF] hover:underline">
                        ¿Olvidé mi contraseña?
                    </a>
                </div>

                <!--texto-->
                <button type="submit"
                        class="w-full bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-4 rounded-xl text-lg transition transform hover:scale-105">
                    Iniciar sesión
                </button>

                <!-- ==================== CREAR CUENTA ==================== -->
                <p class="text-left text-xs text-[#7072BF] mt-4">
                    ¿Primera vez en Nexus? 
                    <a href="/register" class="underline">Crear cuenta</a>
                </p>
            
            </form>
        </div>

        <!-- TEXTO -->
        <p class="text-left text-xs text-[#7072BF] mt-5">
            Powered by Nexus © 2025
        </p>
    </div>


    <!-- SCRIPT DEL OJITO -->
    <script>  //funcion para el ojito que pueda mostrar u ocultar contrasena en el label
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
        
        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
    </script>
</body>
</html>