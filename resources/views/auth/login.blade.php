{{-- resources/views/auth/login.blade.php --}}

<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Nexus</title>

    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font Awesome para el ojito --}}
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <div class="w-full max-w-sm">

        <!-- LOGO -->
        <div class="text-center mb-8">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-12 mx-auto">
        </div>

        <!-- LOGIN CARD -->
        <div class="bg-white p-12 rounded-2xl shadow-2xl">
            <h1 class="text-3xl font-bold text-center text-[#2128A5] mb-8">
                Inicio de Sesión
            </h1>

            {{-- Login consumiendo API --}}
            <form id="loginForm" class="space-y-5">
                @csrf

                {{-- EMAIL --}}
                <div>
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Correo electrónico *
                    </label>
                    <input type="email" id="email" required placeholder="tuemail@gmail.com"
                           class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl 
                           bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">
                    <p id="errorEmail" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                {{-- PASSWORD --}}
                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Contraseña *
                    </label>
                    <input type="password" id="password" required
                           class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl 
                           pr-14 bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">
                    
                    <!-- OJITO -->
                    <button type="button" onclick="togglePassword()" 
                        class="absolute right-4 top-11 text-gray-600 hover:text-gray-900">
                        <i id="eyeIcon" class="fa-solid fa-eye text-xl"></i>
                    </button>

                    <p id="errorPassword" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                {{-- ERROR GENERAL --}}
                <p id="errorMessage" class="text-red-500 text-sm mt-2 hidden"></p>

                {{-- OLVIDÉ CONTRASEÑA --}}
                <div class="text-left">
                    <a href="/password" class="text-xs text-[#7072BF] hover:underline">
                        ¿Olvidé mi contraseña?
                    </a>
                </div>

                {{-- BOTÓN --}}
                <button type="submit" id="loginButton"
                    class="w-full bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-4 
                    rounded-xl text-lg transition transform hover:scale-105 
                    disabled:opacity-60 disabled:cursor-not-allowed">
                    Iniciar sesión
                </button>

                {{-- CREAR CUENTA --}}
                <p class="text-left text-xs text-[#7072BF] mt-4">
                    ¿Primera vez en Nexus?
                    <a href="/register" class="underline">Crear cuenta</a>
                </p>
            
            </form>
        </div>

        {{-- FOOTER --}}
        <p class="text-left text-xs text-[#7072BF] mt-5">
            Powered by Nexus © 2025
        </p>
    </div>

    {{-- SCRIPT: OJITO + LOGIN API --}}
    <script>
        // Mostrar/Ocultar contraseña
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

        // Endpoint API real
        const LOGIN_API_URL = "{{ url('api/login') }}";

        const loginForm     = document.getElementById('loginForm');
        const loginButton   = document.getElementById('loginButton');
        const errorMsg      = document.getElementById('errorMessage');
        const errorEmail    = document.getElementById('errorEmail');
        const errorPassword = document.getElementById('errorPassword');

        loginForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Limpiar errores
            errorMsg.textContent = '';
            errorMsg.classList.add('hidden');
            errorEmail.classList.add('hidden');
            errorPassword.classList.add('hidden');

            const correo     = document.getElementById('email').value;
            const contrasena = document.getElementById('password').value;

            loginButton.disabled = true;
            loginButton.textContent = 'Ingresando...';

            try {
                const response = await fetch(LOGIN_API_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        correo_electronico: correo,
                        contrasena: contrasena
                    })
                });

                const data = await response.json();

                // ❌ Validación (422) o error credenciales (401)
                if (!response.ok || data.success === false) {

                    if (data.errors) {
                        if (data.errors.correo_electronico) {
                            errorEmail.textContent = data.errors.correo_electronico[0];
                            errorEmail.classList.remove('hidden');
                        }
                        if (data.errors.contrasena) {
                            errorPassword.textContent = data.errors.contrasena[0];
                            errorPassword.classList.remove('hidden');
                        }
                    }

                    if (data.message) {
                        errorMsg.textContent = data.message;
                        errorMsg.classList.remove('hidden');
                    }

                    loginButton.disabled = false;
                    loginButton.textContent = 'Iniciar sesión';
                    return;
                }

                // ✔ Login correcto
                const token = data.data.token;
                const user  = data.data.user;

                // Guardar token + usuario
                localStorage.setItem('token', token);
                localStorage.setItem('user', JSON.stringify(user));

                // Redirigir al dashboard
                window.location.href = "/dashboard";

            } catch (error) {
                console.error(error);
                errorMsg.textContent = 'Error de conexión con el servidor.';
                errorMsg.classList.remove('hidden');
            }

            loginButton.disabled = false;
            loginButton.textContent = 'Iniciar sesión';
        });
    </script>
</body>
</html>
