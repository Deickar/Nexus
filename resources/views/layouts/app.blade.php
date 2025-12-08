<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nexus</title>

    <!-- Alpine para el carrito -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- ÍCONOS PHOSPHOR (v2, regular) -->
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.2/src/regular/style.css"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Evita parpadeo de componentes Alpine -->
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>

<body 
    x-data="cartGlobal()"
    class="bg-[#f4f6fb] text-gray-900 flex flex-col min-h-screen"
>

    {{-- NAVBAR RESPONSIVO --}}
    <header 
        class="w-full bg-[#f4f6fb] backdrop-blur-xl border-b border-gray-200"
        x-data="{ openMenu: false }"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-3">

            {{-- LOGO --}}
            <a href="/" class="flex items-center">
                <img src="/img/logo-nexus.png" class="h-9 sm:h-10" alt="Nexus Logo">
            </a>

            {{-- MENÚ DESKTOP --}}
            <nav class="hidden md:flex gap-10 lg:gap-12">
                <a href="{{ route('categories') }}" class="text-[#1d2ea3] text-sm lg:text-lg font-medium hover:text-[#3d50ff] transition">
                    Categorías
                </a>
                <a href="{{ route('offers') }}" class="text-[#1d2ea3] text-sm lg:text-lg font-medium hover:text-[#3d50ff] transition">
                    Ofertas
                </a>
                <a href="{{ route('contact') }}" class="text-[#1d2ea3] text-sm lg:text-lg font-medium hover:text-[#3d50ff] transition">
                    Contacto
                </a>
            </nav>

            {{-- DERECHA: BUSCADOR + ICONOS + HAMBURGER --}}
            <div class="flex items-center gap-3 sm:gap-5">

                {{-- BUSCADOR (oculto en xs, visible desde sm) --}}
                <div class="hidden sm:flex items-center border border-[#1d2ea3] rounded-full px-3 sm:px-4 py-1.5 bg-white shadow-sm max-w-[180px] md:max-w-xs w-full">
                    <input 
                        type="text" 
                        placeholder="¿Qué estás buscando?" 
                        class="bg-transparent outline-none w-full text-xs sm:text-sm text-[#1d2ea3] placeholder-gray-500">
                    <button class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             viewBox="0 0 24 24" 
                             class="w-4 h-4 sm:w-5 sm:h-5 text-[#1d2ea3]">
                            <path fill="currentColor"
                                  d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79L19 20.5a1 1 0 0 0 1.5-1.32L15.5 14Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.505 4.505 0 0 1 9.5 14Z" />
                        </svg>
                    </button>
                </div>

                {{-- ICONO USUARIO --}}
                <a href="{{ route('account.profile') }}" class="text-[#1d2ea3] hover:text-[#3d50ff]">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         viewBox="0 0 24 24" 
                         class="w-5 h-5 sm:w-6 sm:h-6">
                        <path fill="currentColor"
                              d="M12 12a4 4 0 1 0-4-4a4 4 0 0 0 4 4Zm0 2c-3.33 0-6 1.34-6 3v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1v-1c0-1.66-2.67-3-6-3Z" />
                    </svg>
                </a>

               {{-- ICONO CARRITO --}}
        <button 
                x-data
                @click="window.dispatchEvent(new CustomEvent('toggle-cart'))"
                type="button"
                class="relative text-blue-900 hover:text-blue-700 transition"
>
                <svg xmlns="http://www.w3.org/2000/svg" 
                 viewBox="0 0 24 24" 
                class="w-5 h-5 sm:w-6 sm:h-6">
                <!-- Cesta del carrito -->
                <path fill="currentColor"
              d="M5 5h1.4a1 1 0 0 1 .97.76L8.3 8H19a1 1 0 0 1 .98 1.2l-1 5A1 1 0 0 1 18 15H9a1 1 0 0 1-.97-.76L6.1 7H5a1 1 0 0 1 0-2Z" />
                <!-- Ruedas -->
                <circle cx="10" cy="18" r="1.6" fill="currentColor" />
                <circle cx="17" cy="18" r="1.6" fill="currentColor" />
            </svg>
        </button>

                {{-- BOTÓN HAMBURGER (SOLO MÓVIL) --}}
                <button 
                    class="md:hidden text-[#1d2ea3] hover:text-[#3d50ff] focus:outline-none"
                    @click="openMenu = !openMenu"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24">
                        <path fill="currentColor" 
                              d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- MENÚ MÓVIL DESPLEGABLE --}}
        <div 
            class="md:hidden border-t border-gray-200 bg-[#f4f6fb]"
            x-show="openMenu"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            x-cloak
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 space-y-4">

                {{-- BUSCADOR COMPACTO EN MÓVIL --}}
                <div class="flex items-center border border-[#1d2ea3] rounded-full px-3 py-1.5 bg-white shadow-sm">
                    <input 
                        type="text" 
                        placeholder="¿Qué estás buscando?"
                        class="bg-transparent outline-none w-full text-sm text-[#1d2ea3] placeholder-gray-500">
                    <button class="ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             viewBox="0 0 24 24" 
                             class="w-5 h-5 text-[#1d2ea3]">
                            <path fill="currentColor"
                                  d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79L19 20.5a1 1 0 0 0 1.5-1.32L15.5 14Zm-6 0A4.5 4.5 0 1 1 14 9.5 4.505 4.505 0 0 1 9.5 14Z" />
                        </svg>
                    </button>
                </div>

                {{-- LINKS DEL MENÚ --}}
                <nav class="flex flex-col gap-2 text-sm">
                    <a href="{{ route('categories') }}" class="py-1 text-[#1d2ea3] font-medium hover:text-[#3d50ff]">
                        Categorías
                    </a>
                    <a href="{{ route('offers') }}" class="py-1 text-[#1d2ea3] font-medium hover:text-[#3d50ff]">
                        Ofertas
                    </a>
                    <a href="{{ route('contact') }}" class="py-1 text-[#1d2ea3] font-medium hover:text-[#3d50ff]">
                        Contacto
                    </a>
                </nav>
            </div>
        </div>
    </header>

    {{-- CONTENIDO --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- CARRITO (COMPONENTE) --}}
    @include('carrito')

    {{-- FOOTER RESPONSIVO --}}
    @hasSection('no_footer')
    @else
        <footer class="mt-0 py-10 bg-[#6f73bf] text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                {{-- CONTENEDOR PRINCIPAL --}}
                <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-8">

                    {{-- LOGO --}}
                    <div class="flex-shrink-0">
                        <img src="/img/logo-nexus.png" alt="Nexus" class="h-12 sm:h-14">
                    </div>

                    {{-- MENÚ + REDES --}}
                    <div class="flex flex-col items-center md:items-end gap-5">

                        {{-- MENÚ --}}
                        <nav class="flex flex-wrap justify-center md:justify-end gap-x-8 gap-y-2 text-sm sm:text-base md:text-lg font-semibold">
                            <a href="{{ route('categories') }}" class="hover:text-gray-200 transition">
                                Categorías
                            </a>
                            <a href="{{ route('offers') }}" class="hover:text-gray-200 transition">
                                Ofertas
                            </a>
                            <a href="{{ route('contact') }}" class="hover:text-gray-200 transition">
                                Contacto
                            </a>
                        </nav>

                        {{-- REDES SOCIALES --}}
                        <div class="flex items-center gap-5 text-2xl">
                            {{-- FACEBOOK --}}
                            <a href="#" class="hover:opacity-80 transition" aria-label="Facebook">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    class="w-6 h-6 sm:w-7 sm:h-7">
                                    <path fill="currentColor"
                                        d="M13 21v-7h2.3l.4-3H13V8.5C13 7.6 13.3 7 14.7 7H16V4.2C15.3 4.1 14.4 4 13.5 4 11 4 9.3 5.5 9.3 8.2V11H7v3h2.3v7Z" />
                                </svg>
                            </a>

                            {{-- INSTAGRAM --}}
                            <a href="#" class="hover:opacity-80 transition" aria-label="Instagram">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    class="w-6 h-6 sm:w-7 sm:h-7">
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
                                    class="w-6 h-6 sm:w-7 sm:h-7">
                                    <path fill="currentColor"
                                        d="M16.5 7.2a4 4 0 0 1-1.9-3.2h-2.4v9.3a2.3 2.3 0 1 1-1.8-2.2v-2.4A4.7 4.7 0 1 0 14 16V8.7a6.3 6.3 0 0 0 3 1Z" />
                                </svg>
                            </a>
                        </div>

                    </div>

                </div>

                {{-- LÍNEA + COPYRIGHT --}}
                <div class="w-full border-t border-white/20 mt-8 pt-4 text-center">
                    <p class="text-xs sm:text-sm opacity-80">
                        © {{ date('Y') }} NEXUS. Todos los derechos reservados.
                    </p>
                </div>
            </div>
        </footer>
    @endif

    <!-- script para funcionamiento del carrito -->
    <script>
        function cartGlobal() {
            return {
                cartItems: JSON.parse(localStorage.getItem('cartItems')) || [],
                
                get totalItems() {
                    return this.cartItems.reduce((sum, item) => sum + item.qty, 0);
                },

                get totalAmount() {
                    return this.cartItems.reduce((sum, item) => sum + (item.qty * item.price), 0);
                },

                addToCart(product) {
                    let exists = this.cartItems.find(p => p.id === product.id);

                    if (exists) {
                        exists.qty++;
                    } else {
                        this.cartItems.push(product);
                    }

                    this.save();
                    window.dispatchEvent(new CustomEvent('open-cart'));
                },

                save() {
                    localStorage.setItem('cartItems', JSON.stringify(this.cartItems));
                }
            }
        }
    </script>

</body>
</html>
