<!DOCTYPE html> 
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - Nexus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="min-h-screen bg-[#F2F2F2] flex items-center justify-center px-4">

    <!-- REGISTER -->
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

            {{-- Ya no usamos action="/register", lo maneja JS con la API --}}
            <form id="registerForm" class="space-y-3">  
                @csrf

                <!-- PRIMER NOMBRE -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Primer Nombre : *
                    </label>
                    <input type="text" id="primer_nombre" required placeholder="Felipe"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl 
                           bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <p id="errorNombreCompleto" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- APELLIDO -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Apellido : *
                    </label>
                    <input type="text" id="apellido" required placeholder="Esquivel"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl 
                           bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                </div>

                <!-- CORREO -->
                <div class="text-center">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Correo Electrónico : *
                    </label>
                    <input type="email" id="email" required placeholder="tucorreo@example.com"
                           class="w-full max-w-xs px-6 py-1.5 border-2 border-[#2128A5] rounded-xl 
                           bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <p id="errorEmail" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- CONTRASEÑA -->
                <div class="text-center relative">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Contraseña : *
                    </label>
                    <input type="password" id="password" required
                           class="w-full max-w-xs px-6 py-1.5 pr-10 border-2 border-[#2128A5] 
                           rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <button type="button" onclick="togglePassword('password', 'eye1')"
                            class="absolute right-4 top-5 text-gray-600 hover:text-gray-800">
                        <i id="eye1" class="fa-solid fa-eye text-sm"></i>
                    </button>
                    <p id="errorPassword" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- CONFIRMAR CONTRASEÑA-->
                <div class="text-center relative">
                    <label class="px-5 block text-[#7072BF] font-semibold text-left text-xs">
                        Confirmar Contraseña : *
                    </label>
                    <input type="password" id="password_confirmation" required
                           class="w-full max-w-xs px-6 py-1.5 pr-10 border-2 border-[#2128A5] 
                           rounded-xl bg-[#f2f2f2] focus:ring-2 focus:ring-blue-300 text-sm">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eye2')"
                            class="absolute right-4 top-5 text-gray-600 hover:text-gray-800">
                        <i id="eye2" class="fa-solid fa-eye text-sm"></i>
                    </button>
                    <p id="errorPasswordConfirm" class="text-red-500 text-xs mt-1 hidden"></p>
                </div>

                <!-- CHECKBOX -->
                <div class="flex items-center justify-center mt-3">
                    <label class="flex items-center cursor-pointer text-xs text-[#7072BF]">
                        <input type="checkbox" id="check_terms" class="hidden peer" required>
                        <div class="w-4 h-4 border-2 border-[#2128A5] rounded mr-2 
                                    peer-checked:bg-[#2128A5] transition flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" 
                                 stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" 
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        Acepto los términos y condiciones. Haga click aquí
                    </label>
                </div>

                <!-- ERROR GENERAL -->
                <p id="errorGeneral" class="text-red-500 text-xs mt-2 hidden"></p>

                <!-- BOTÓN -->
                <div class="text-center mt-4">
                    <button type="submit" id="registerButton"
                            class="bg-[#2128A5] hover:bg-blue-700 text-white font-bold py-2 px-14 
                                   rounded-xl text-base transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Registrar
                    </button>
                </div>
            </form>

            <p class="text-left text-xs text-[#7072BF] mt-4">
                <a href="/login" class="no-underline hover:text-[#2128A5]">
                    ¿Ya tienes cuenta? Iniciar Sesión
                </a>
            </p>
        </div>

        <p class="text-left text-xs text-[#7072BF] mt-2">
            Powered by Nexus © 2025
        </p>
    </div>

    <!-- SCRIPT + CONSUMO API -->
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

    const REGISTER_API_URL = "{{ url('api/register') }}";

    const registerForm        = document.getElementById('registerForm');
    const registerButton      = document.getElementById('registerButton');
    const errorNombreCompleto = document.getElementById('errorNombreCompleto');
    const errorEmail          = document.getElementById('errorEmail');
    const errorPassword       = document.getElementById('errorPassword');
    const errorPasswordConf   = document.getElementById('errorPasswordConfirm');
    const errorGeneral        = document.getElementById('errorGeneral');

    registerForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Limpiar errores
        [errorNombreCompleto, errorEmail, errorPassword, errorPasswordConf, errorGeneral].forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });

        const primerNombre = document.getElementById('primer_nombre').value.trim();
        const apellido     = document.getElementById('apellido').value.trim();
        const email        = document.getElementById('email').value.trim();
        const password     = document.getElementById('password').value;
        const passwordConf = document.getElementById('password_confirmation').value;
        const terms        = document.getElementById('check_terms').checked;

        // Validación básica en frontend
        if (!terms) {
            errorGeneral.textContent = 'Debes aceptar los términos y condiciones.';
            errorGeneral.classList.remove('hidden');
            return;
        }

        if (password !== passwordConf) {
            errorPasswordConf.textContent = 'Las contraseñas no coinciden.';
            errorPasswordConf.classList.remove('hidden');
            return;
        }

        const nombreCompleto = (primerNombre + ' ' + apellido).trim();

        registerButton.disabled = true;
        registerButton.textContent = 'Registrando...';

        try {
            const response = await fetch(REGISTER_API_URL, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    // NOMBRES EXACTOS que valida RegisterRequest
                    nombre_completo:    nombreCompleto,
                    correo_electronico: email,
                    contrasena:         password
                    // Opcionales: telefono, direccion, id_rol si luego los agregas al formulario
                })
            });

            let data = null;
            try {
                data = await response.json();
            } catch (e) {
                data = null;
            }

            // Errores de validación (422) u otros (400)
            if (!response.ok || !data || data.success === false) {

                if (data && data.errors) {
                    if (data.errors.nombre_completo) {
                        errorNombreCompleto.textContent = data.errors.nombre_completo[0];
                        errorNombreCompleto.classList.remove('hidden');
                    }
                    if (data.errors.correo_electronico) {
                        errorEmail.textContent = data.errors.correo_electronico[0];
                        errorEmail.classList.remove('hidden');
                    }
                    if (data.errors.contrasena) {
                        errorPassword.textContent = data.errors.contrasena[0];
                        errorPassword.classList.remove('hidden');
                    }
                }

                if (data && data.message) {
                    errorGeneral.textContent = data.message;
                    errorGeneral.classList.remove('hidden');
                } else if (!data) {
                    errorGeneral.textContent = 'Error inesperado en el servidor.';
                    errorGeneral.classList.remove('hidden');
                }

                registerButton.disabled = false;
                registerButton.textContent = 'Registrar';
                return;
            }

            // Registro exitoso -> AuthService devuelve user + token
            const token = data.data.token;
            const user  = data.data.user;

            localStorage.setItem('token', token);
            localStorage.setItem('user', JSON.stringify(user));

            // Redirigir al dashboard (ajusta si quieres a /login)
            window.location.href = "{{ url('/dashboard') }}";

        } catch (error) {
            console.error(error);
            errorGeneral.textContent = 'No se pudo conectar con el servidor. Intenta más tarde.';
            errorGeneral.classList.remove('hidden');
            registerButton.disabled = false;
            registerButton.textContent = 'Registrar';
        }
    });
    </script>
</body>
</html>
