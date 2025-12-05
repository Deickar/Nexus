<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900 flex flex-col min-h-screen">

    {{-- NAVBAR --}}
    <header class="w-full bg-[#f4f6fb] backdrop-blur-xl border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-8 py-4 flex items-center justify-between">

            {{-- LOGO --}}
            <a href="/" class="flex items-center">
                <img src="/img/logo-nexus.png" class="h-10" alt="Nexus Logo">
            </a>

            {{-- MENÚ --}}
            <nav class="hidden md:flex gap-12">
                <a href="#" class="text-[#1d2ea3] text-lg font-medium hover:text-[#3d50ff] transition">
                    Categorías
                </a>
                <a href="#" class="text-[#1d2ea3] text-lg font-medium hover:text-[#3d50ff] transition">
                    Ofertas
                </a>
                <a href="{{ route('contact') }}" class="text-[#1d2ea3] text-lg font-medium hover:text-[#3d50ff] transition">
                    Contacto
                </a>
            </nav>

            {{-- DERECHA: BUSCADOR + ICONOS --}}
            <div class="flex items-center gap-6">

                {{-- BUSCADOR CON LUPA --}}
                <div class="flex items-center border border-[#1d2ea3] rounded-full px-4 py-2 bg-white shadow-sm">
                    <input 
                        type="text" 
                        placeholder="¿Qué estás buscando?" 
                        class="bg-transparent outline-none w-40 md:w-56 text-sm text-[#1d2ea3] placeholder-gray-500">

                    {{-- ICONO LUPA (SVG) --}}
                    <button class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             viewBox="0 0 24 24" 
                             class="w-5 h-5 text-[#1d2ea3]">
                            <path fill="currentColor"
                                  d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79L19 20.5a1 1 0 0 0 1.5-1.32L15.5 14Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.505 4.505 0 0 1 9.5 14Z" />
                        </svg>
                    </button>
                </div>

                {{-- ICONO USUARIO (SVG) --}}
                <button class="text-[#1d2ea3] hover:text-[#3d50ff]">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         viewBox="0 0 24 24" 
                         class="w-6 h-6">
                        <path fill="currentColor"
                              d="M12 12a4 4 0 1 0-4-4a4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 3v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1c0-1.66-2.67-3-6-3Z" />
                    </svg>
                </button>

                {{-- ICONO CARRITO (SVG) --}}
                <button class="text-[#1d2ea3] hover:text-[#3d50ff]">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         viewBox="0 0 24 24" 
                         class="w-6 h-6">
                        <path fill="currentColor"
                              d="M7 18a2 2 0 1 0 2 2a2 2 0 0 0-2-2Zm10 0a2 2 0 1 0 2 2a2 2 0 0 0-2-2ZM6.2 6l-.35-1.4A1 1 0 0 0 4.88 4H3a1 1 0 0 0 0 2h1.17l2.1 8.39A1 1 0 0 0 7.24 15h9.52a1 1 0 0 0 1-.76l1.24-5A1 1 0 0 0 18 8H7.42L7.09 6.8A1 1 0 0 0 6.2 6Z" />
                    </svg>
                </button>

            </div>
        </div>
    </header>

    {{-- CONTENIDO --}}
    <main>
        @yield('content')
    </main>

@hasSection('no_footer')
  @else
    <footer class="mt-0 py-12 bg-[#6f73bf] text-white">
    <div class="max-w-7xl mx-auto px-8">

        {{-- CONTENEDOR EN DOS COLUMNAS --}}
        <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-10">

            {{-- LOGO IZQUIERDA --}}
            <div>
                <img src="/img/logo-nexus.png" alt="Nexus" class="h-14">
            </div>

            {{-- MENÚ + REDES DERECHA --}}
            <div class="flex flex-col items-center md:items-end gap-6">

                {{-- MENÚ --}}
                <nav class="flex gap-10 text-white text-lg font-semibold">
                    <a href="#" class="hover:text-gray-200 transition">Categorias</a>
                    <a href="#" class="hover:text-gray-200 transition">Ofertas</a>
                    <a href="#" class="hover:text-gray-200 transition">Contacto</a>
                </nav>

                {{-- ICONOS REDES SOCIALES --}}
                <div class="flex items-center gap-6 text-2xl">

                    {{-- FACEBOOK --}}
                    <a href="#" class="hover:opacity-80 transition" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             class="w-7 h-7">
                            <path fill="currentColor"
                                d="M13 21v-7h2.3l.4-3H13V8.5C13 7.6 13.3 7 14.7 7H16V4.2C15.3 4.1 14.4 4 13.5 4 11 4 9.3 5.5 9.3 8.2V11H7v3h2.3v7Z" />
                        </svg>
                    </a>

                    {{-- INSTAGRAM --}}
                    <a href="#" class="hover:opacity-80 transition" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             class="w-7 h-7">
                            <rect x="4" y="4" width="16" height="16" rx="4" ry="4"
                                  fill="none" stroke="currentColor" stroke-width="2" />
                            <circle cx="12" cy="12" r="3.8"
                                    fill="none" stroke="currentColor" stroke-width="2" />
                            <circle cx="17" cy="7" r="1.3" fill="currentColor" />
                        </svg>
                    </a>

                    {{-- TIKTOK --}}
                    <a href="#" class="hover:opacity-80 transition" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 24 24"
                             class="w-7 h-7">
                            <path fill="currentColor"
                                d="M16.5 7.2a4 4 0 0 1-1.9-3.2h-2.4v9.3a2.3 2.3 0 1 1-1.8-2.2v-2.4A4.7 4.7 0 1 0 14 16V8.7a6.3 6.3 0 0 0 3 1Z" />
                        </svg>
                    </a>

                </div>

            </div>

        </div>

        {{-- LÍNEA + COPYRIGHT --}}
        <div class="w-full border-t border-white/20 mt-10 pt-4 text-center">
            <p class="text-sm opacity-80">
                © {{ date('Y') }} NEXUS. Todos los derechos reservados.
            </p>
        </div>

    </div>
</footer>
@endif



</body>
</html>
