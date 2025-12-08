<!DOCTYPE html> 
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Nexus Ecommerce</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-10">
            <img src="{{ asset('img/logo-nexus.png') }}" alt="Logo" class="h-16 mx-auto">
        </div>

        <div class="bg-white p-12 rounded-3xl shadow-2xl">
            <h1 class="text-2xl font-bold text-center text-[#2128A5] mb-4">
                ¿Olvidaste tu contraseña?
            </h1>

            <p class="text-center text-gray-600 mb-6 text-sm">
                Ingresa tu correo y generaremos un token para que puedas crear una nueva contraseña.
            </p>

            {{-- Ya no usamos action="/password", lo manejamos con JS llamando al API --}}
            <form id="forgotForm" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[#7072BF] font-semibold mb-2">
                        Correo electrónico *
                    </label>

                    <input type="email" id="email" required placeholder="tuemail@gmail.com"
                           class="w-full px-5 py-3 border-2 border-[#2128A5] rounded-xl 
                                  bg-[#f2f2f2] focus:ring-4 focus:ring-blue-300 text-base">
                    <p id="errorEmail" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <p id="errorGeneral" class="text-red-500 text-xs mt-1 hidden"></p>
                <p id="successMessage" class="text-green-600 text-xs mt-1 hidden"></p>

                <div class="flex justify-center mt-4">
                    <button type="submit" id="sendButton"
                            class="w-auto px-8 bg-[#2128A5] hover:bg-blue-700 text-white 
                                   font-bold py-3 rounded-xl text-base transition
                                   disabled:opacity-60 disabled:cursor-not-allowed">
                        Enviar correo
                    </button>
                </div>
            </form>

            <p class="text-center text-sm text-[#7072BF] mt-6">
                <a href="/login" class="underline hover:text-[#2128A5]">
                    Regresar al Inicio de Sesión
                </a>
            </p>
        </div>

        <p class="text-left text-xs text-[#7072BF] mt-4">
            Desarrollado por Nexus Ecommerce © 2025
        </p>
    </div>

    <script>
        const FORGOT_API_URL = "{{ url('api/password/forgot') }}";

        const forgotForm     = document.getElementById('forgotForm');
        const sendButton     = document.getElementById('sendButton');
        const errorEmail     = document.getElementById('errorEmail');
        const errorGeneral   = document.getElementById('errorGeneral');
        const successMessage = document.getElementById('successMessage');

        forgotForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            // Limpiar mensajes
            [errorEmail, errorGeneral, successMessage].forEach(el => {
                el.textContent = '';
                el.classList.add('hidden');
            });

            const email = document.getElementById('email').value.trim();

            sendButton.disabled = true;
            sendButton.textContent = 'Enviando...';

            try {
                const response = await fetch(FORGOT_API_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        // Campo EXACTO que espera PasswordResetController / ForgotPasswordRequest
                        email: email
                    }),
                });

                let data = null;
                try {
                    data = await response.json();
                } catch (e) {
                    data = null;
                }

                // Errores de validación o lógicos
                if (!response.ok || (data && data.success === false)) {

                    // Validación típica: required/email
                    if (data && data.errors && data.errors.email) {
                        errorEmail.textContent = data.errors.email[0];
                        errorEmail.classList.remove('hidden');
                    }

                    if (data && data.message) {
                        errorGeneral.textContent = data.message;
                        errorGeneral.classList.remove('hidden');
                    } else if (!data) {
                        errorGeneral.textContent = 'Error inesperado en el servidor.';
                        errorGeneral.classList.remove('hidden');
                    }

                    sendButton.disabled = false;
                    sendButton.textContent = 'Enviar correo';
                    return;
                }

                // ÉXITO: mensaje genérico
                const msg = (data && data.message)
                    ? data.message
                    : 'Si el correo existe, se ha generado un token de recuperación.';

                successMessage.textContent = msg;
                successMessage.classList.remove('hidden');

                // Opcional: mostrar token en desarrollo (si viene)
                if (data && data.data && data.data.token) {
                    const devInfo = ` Token (solo desarrollo): ${data.data.token}`;
                    successMessage.textContent += devInfo;
                }

                // Si quieres limpiar el input
                // document.getElementById('email').value = '';

            } catch (error) {
                console.error(error);
                errorGeneral.textContent = 'No se pudo conectar con el servidor. Intenta más tarde.';
                errorGeneral.classList.remove('hidden');
            } finally {
                sendButton.disabled = false;
                sendButton.textContent = 'Enviar correo';
            }
        });
    </script>
</body>
</html>
