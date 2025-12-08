<!DOCTYPE html> 
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña - Nexus</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                Establece tu nueva contraseña.
            </p>

            {{-- IMPORTANT: YA NO ACTION="/reset-password". Usamos fetch --}}
            <form id="resetForm" class="space-y-6">

                <!-- EMAIL (oculto pero obligatorio para API) -->
                <input type="hidden" id="email" value="{{ request()->query('email') }}">

                <!-- TOKEN (oculto) -->
                <input type="hidden" id="token" value="{{ request()->query('token') }}">

                <!-- NUEVA CONTRASEÑA -->
                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Nueva contraseña *
                    </label>
                    <input type="password" id="new_password" required
                           placeholder="Escribe tu nueva contraseña"
                           class="text-xs w-full px-5 py-2 border-2 border-[#2128A5] rounded-xl pr-14 
                                  bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300">
                    <button type="button" onclick="togglePassword('new_password','eye1')"
                            class="absolute right-4 top-11 text-gray-600">
                        <i id="eye1" class="fa-solid fa-eye"></i>
                    </button>
                    <p id="errorPassword" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- CONFIRMAR CONTRASEÑA -->
                <div class="relative">
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Confirmar contraseña *
                    </label>
                    <input type="password" id="confirm_password" required
                           placeholder="Repite la contraseña"
                           class="text-xs w-full px-5 py-2 border-2 border-[#2128A5] rounded-xl pr-14 
                                  bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300">
                    <button type="button" onclick="togglePassword('confirm_password','eye2')"
                            class="absolute right-4 top-11 text-gray-600">
                        <i id="eye2" class="fa-solid fa-eye"></i>
                    </button>
                    <p id="errorPasswordConfirm" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- ERRORES GENERALES -->
                <p id="errorGeneral" class="text-red-500 text-xs mt-1 hidden"></p>

                <!-- ÉXITO -->
                <p id="successMessage" class="text-green-600 text-xs mt-1 hidden"></p>

                <!-- BOTÓN -->
                <div class="flex justify-center">
                    <button type="submit" id="resetButton"
                            class="w-auto px-10 bg-[#2128A5] hover:bg-blue-700 text-white font-bold 
                                   py-3 rounded-xl text-base transition
                                   disabled:opacity-60 disabled:cursor-not-allowed">
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
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        const RESET_API_URL = "{{ url('api/password/reset') }}";

        const resetForm     = document.getElementById('resetForm');
        const resetButton   = document.getElementById('resetButton');
        const errorPassword = document.getElementById('errorPassword');
        const errorPasswordConfirm = document.getElementById('errorPasswordConfirm');
        const errorGeneral  = document.getElementById('errorGeneral');
        const successMsg    = document.getElementById('successMessage');

        resetForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            // Limpiar mensajes
            [errorPassword, errorPasswordConfirm, errorGeneral, successMsg].forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });

            const email    = document.getElementById('email').value;
            const token    = document.getElementById('token').value;
            const pwd      = document.getElementById('new_password').value;
            const pwdConf  = document.getElementById('confirm_password').value;

            if (pwd !== pwdConf) {
                errorPasswordConfirm.textContent = "Las contraseñas no coinciden.";
                errorPasswordConfirm.classList.remove('hidden');
                return;
            }

            resetButton.disabled = true;
            resetButton.textContent = "Guardando...";

            try {
                const response = await fetch(RESET_API_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        token: token,
                        password: pwd,
                        password_confirmation: pwdConf
                    }),
                });

                const data = await response.json();

                // ❌ errores
                if (!response.ok || data.success === false) {

                    if (data.errors && data.errors.password) {
                        errorPassword.textContent = data.errors.password[0];
                        errorPassword.classList.remove('hidden');
                    }

                    if (data.message) {
                        errorGeneral.textContent = data.message;
                        errorGeneral.classList.remove('hidden');
                    }

                    resetButton.disabled = false;
                    resetButton.textContent = "Guardar Contraseña";
                    return;
                }

                // ✔ EXITO
                successMsg.textContent = data.message || "Contraseña restablecida.";
                successMsg.classList.remove('hidden');

                // Redirigir automáticamente a login en 2.5 segundos
                setTimeout(() => {
                    window.location.href = "/login";
                }, 2500);

            } catch (error) {
                console.error(error);
                errorGeneral.textContent = "Error de conexión.";
                errorGeneral.classList.remove('hidden');
            }

            resetButton.disabled = false;
            resetButton.textContent = "Guardar Contraseña";
        });
    </script>

</body>
</html>
