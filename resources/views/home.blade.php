@extends('layouts.app')

@section('content')
<div class="bg-[#f4f6fb]">

    {{-- PERFIL RESUMIDO AL ESTAR LOGUEADO --}}
    @auth
        <section class="bg-[#f4f6fb] py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-8">
                <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Bienvenido(a)</p>
                        <h2 class="text-2xl font-extrabold text-[#2128A6] leading-tight">
                            {{ auth()->user()->nombre_completo ?? auth()->user()->name ?? 'Tu perfil' }}
                        </h2>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ auth()->user()->correo_electronico ?? auth()->user()->email ?? '' }}
                        </p>
                    </div>

                    <div class="mt-4 md:mt-0 flex gap-3">
                        <a href="{{ route('account.profile') }}"
                           class="inline-flex items-center justify-center
                                  bg-[#2128A6] hover:bg-[#6F73BF]
                                  text-white text-sm font-semibold
                                  px-5 py-2 rounded-full shadow-md transition">
                            Ver perfil completo
                        </a>

                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="inline-flex items-center justify-center
                                  bg-gray-200 hover:bg-gray-300
                                  text-gray-700 text-sm font-semibold
                                  px-5 py-2 rounded-full transition">
                            Cerrar sesión
                        </a>
                    </div>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </section>
    @endauth

    {{-- HERO PRINCIPAL --}}
    <section class="relative w-full bg-cover bg-center"
             style="background-image: url('/img/fondo-nexus.jpg');">

        {{-- Capa ligera para dar contraste al texto --}}
        <div class="absolute inset-0 bg-black/10"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-8 py-16 md:py-24 grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- TEXTO --}}
            <div class="flex flex-col justify-center">
                <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-[#6F73BF] leading-tight drop-shadow">
                    Encuentra lo<br> que buscas
                </h2>

                <p class="font-bold text-[#2128A6] mt-4 text-2xl max-w-md">
                    Productos seleccionados para  <br> tu estilo de vida.
                </p>

                <div class="flex flex-col justify-center max-w-md">
                    <a href="{{ route('categories') }}"
                       class="mt-6 inline-flex items-center justify-center
                              bg-[#30D9C8] hover:bg-[#77D9CF]
                              text-white text-2xl font-semibold
                              px-6 py-2 rounded-full shadow-lg transition">
                        Comprar ahora
                    </a>
                </div>
            </div>

            {{-- COLUMNA DERECHA (solo deja ver la imagen del fondo) --}}
            <div class="hidden md:block"></div>

        </div>
    </section>

    {{-- MARCAS --}}
    <section class="bg-[#f4f6fb]">
        <div class="max-w-7xl mx-auto px-4 sm:px-8 py-10 flex flex-wrap gap-10 items-center justify-center md:justify-between">
            <img src="/img/jbl.png"     class="h-22 object-contain opacity-80 hover:opacity-100 transition" alt="JBL">
            <img src="/img/boss.png"    class="h-13 object-contain opacity-80 hover:opacity-100 transition" alt="Boss">
            <img src="/img/lenovo.png"  class="h-16 object-contain opacity-80 hover:opacity-100 transition" alt="Lenovo">
            <img src="/img/zara.png"    class="h-23 object-contain opacity-80 hover:opacity-100 transition" alt="Zara">
            <img src="/img/philips.png" class="h-18 object-contain opacity-80 hover:opacity-100 transition" alt="Philips">
        </div>
    </section>

    {{-- PRODUCTOS NUEVOS (CARRUSEL) --}}
    <section class="bg-[#f4f6fb] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">

            <h3 class="text-3xl text-[#2128A6] font-extrabold mb-8">
                Productos nuevos
            </h3>

            @php
                $productosNuevos = $productosNuevos ?? collect();
            @endphp

            <div class="relative">

                {{-- Flecha izquierda --}}
                <button id="btnLeft"
                    class="hidden md:flex items-center justify-center absolute -left-4 top-1/2 -translate-y-1/2
                           bg-white shadow-md rounded-full p-3 z-10 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                {{-- Carrusel --}}
                <div id="carouselProducts"
                     class="flex gap-8 pb-3
                            overflow-x-auto md:overflow-hidden
                            scroll-smooth">

                    @forelse ($productosNuevos as $producto)
                        @php
                            $id_imagen  = $producto->id_imagen;
                            $idProducto = $producto->id_producto;
                            $nombre     = $producto->nombre_producto;
                            $descripcion = $producto->descripcion ?? 'Sin descripción';
                            $precio      = (float) $producto->precio;

                            $imagen = '/img/placeholder.png';

                            $productPayload = [
                                'product' => [
                                    'id_producto' => $idProducto,
                                    'name'        => $nombre,
                                    'price'       => $precio,
                                    'image'       => $id_imagen,
                                ],
                            ];
                        @endphp

                        <article
                            x-data='@json($productPayload)'
                            class="min-w-[260px] bg-white rounded-2xl shadow-md hover:shadow-xl transition p-5 flex flex-col justify-between snap-start"
                            data-product-id="{{ $idProducto }}">

                            {{-- contenedor de imagen y descripcion --}}
                            <div>
                                <img :src="product.image" class="rounded-xl mb-4 w-full object-cover" alt="{{ $nombre }}" style="min-height: 200px;">
                                <h4 class="font-semibold text-[#6F73BF] ">{{ $nombre }}</h4>
                                <p class="text-sm text-black mt-1">
                                    {{ \Illuminate\Support\Str::limit($descripcion, 120) }}
                                </p>
                            </div>

                            <div class="mt-4">
                                <p class="font-bold text-[#2128a6]">
                                    Q {{ number_format($precio, 2) }}
                                </p>

                                <button
                                    @click="window.dispatchEvent(new CustomEvent('add-to-cart', { detail: product }))"
                                    class="mt-3 w-full bg-[#6F73BF] hover:bg-[#2128a6] text-white text-sm font-semibold py-2.5 rounded-lg">
                                    Añadir al carrito
                                </button>
                            </div>
                        </article>
                    @empty
                        <p class="text-gray-500 text-sm">
                            No hay productos nuevos disponibles por el momento.
                        </p>
                    @endforelse

                </div>

                {{-- Flecha derecha --}}
                <button id="btnRight"
                    class="hidden md:flex items-center justify-center absolute -right-4 top-1/2 -translate-y-1/2
                           bg-white shadow-md rounded-full p-3 z-10 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5l7 7-7 7" />
                    </svg>
                </button>

            </div>

            {{-- BOTÓN VER TODO --}}
            <div class="text-center mt-12">
                <a href="{{ route('categories') }}"
                    class="inline-flex items-center justify-center bg-[#2128a6] text-white font-semibold px-20 py-3 rounded-full shadow-md transition">
                    Ver todo lo nuevo
                </a>
            </div>

        </div>
    </section>

    {{-- BENEFICIOS --}}
    <section class="bg-[#f4f6fb] py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 grid gap-10 md:grid-cols-3 text-center">

            {{-- Envío gratis --}}
            <div class="flex flex-col items-center">
                <div class="w-25 h-25 rounded-full bg-[#3d50ff]/10 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="w-20 h-20 text-[#2128a6]" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7h10v9H3zM13 10h3.5L21 13v3h-8zM7 18a2 2 0 11-4 0 2 2 0 014 0zm10 0a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h4 class="font-semibold text-xl text-[#6F73BF]">Envío gratis</h4>
                <p class="text-sm text-black mt-1">
                    En compras mayores a Q300.
                </p>
            </div>

            {{-- Soporte --}}
            <div class="flex flex-col items-center">
                <div class="w-25 h-25 rounded-full bg-[#3d50ff]/10 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor"
                        class="w-20 h-20  text-[#2128a6]">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 1a9 9 0 00-9 9v4a3 3 0 003 3h1v-7H6V10a6 6 0 0112 0v3h-1v7h1a3 3 0 003-3v-4a9 9 0 00-9-9zm-4 18h4m4 0h-4" />
                    </svg>
                </div>
                <h4 class="font-semibold text-xl text-[#6F73BF]">Soporte 24/7</h4>
                <p class="text-sm text-black mt-1">
                    30 días para reportar inconvenientes.
                </p>
            </div>

            {{-- Garantía --}}
            <div class="flex flex-col items-center">
                <div class="w-25 h-25 rounded-full bg-[#3d50ff]/10 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        class="w-20 h-20  text-[#2128a6]" fill="currentColor">
                        <path
                            d="M12 2.5l2.9 5.88 6.1.89-4.4 4.3 1 6.03L12 17.5l-5.6 2.93 1-6.03-4.4-4.3 6.1-.89L12 2.5z" />
                    </svg>
                </div>
                <h4 class="font-semibold text-xl text-[#6F73BF]">Garantía</h4>
                <p class="text-sm text-black mt-1">
                    3–12 meses según el producto.
                </p>
            </div>

        </div>
    </section>

    {{-- EXPLORAR MÁS --}}
    <section class="bg-[#f4f6fb] py-16">

        <div class="max-w-7xl mx-auto px-4 sm:px-8">
            <h3 class="text-3xl text-[#2128A6] font-extrabold mb-8">
                Explorar más
            </h3>
        </div>

        <div class="w-full">
            <div class="bg-white rounded-3xl shadow-md overflow-hidden
                        grid grid-cols-1 md:grid-cols-2 gap-0 items-center w-full">

                {{-- Imagen izquierda --}}
                <div class="w-full h-full">
                    <img src="/img/collagetienda.png"
                        alt="Explora más productos"
                        class="w-full h-full object-cover">
                </div>

                {{-- Texto derecha --}}
                <div class="px-8 md:pl-20 lg:pl-28 py-10 md:py-14 flex flex-col justify-center">
                    <h2 class="text-4xl md:text-6xl lg:text-7xl font-extrabold
                                text-[#6F73BF] leading-tight drop-shadow">
                        Encuentra lo<br>
                        que te inspira...
                    </h2>

                    <p class="font-bold text-[#2128A6] mt-4 text-2xl max-w-md">
                        Tecnología, hogar y más, todo en un solo lugar.
                    </p>

                    <a href="{{ route('categories') }}"
                        class="mt-6 inline-flex items-center justify-center
                                bg-[#2128a6] hover:bg-[#6F73BF]
                                text-white text-lg font-semibold
                                px-6 py-2 rounded-full shadow-lg transition
                                w-fit">
                        Ver productos
                    </a>
                </div>

            </div>
        </div>

    </section>

    {{-- REVIEWS DE CLIENTES --}}
    <section class="bg-[#f4f6fb] py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-8">

            <h3 class="text-3xl text-[#2128A6] font-extrabold mb-8">
                Lo que dicen nuestros clientes
            </h3>
            <p class="text-sm text-gray-500 mb-8">
                Reseñas de personas que ya confiaron en Nexus.
            </p>

            @php
                $reviewsHome = $reviewsHome ?? collect();
            @endphp

            <div class="grid gap-6 md:grid-cols-2">

                @forelse ($reviewsHome as $review)
                    @php
                        $user = $review->usuario;

                        $nombreCliente = $user->nombre_completo
                            ?? $user->name
                            ?? 'Cliente';

                        $correoCliente = $user->correo_electronico
                            ?? $user->email
                            ?? 'correo@ejemplo.com';

                        $fecha = optional($review->review_date)->format('d M Y');
                        $comentario = $review->comment ?: 'Sin comentario';
                    @endphp

                    <article class="bg-white rounded-2xl shadow-md p-6 flex gap-4 items-start">
                        <img src="/img/placeholder.png"
                            alt="Foto cliente"
                            class="w-20 h-20 rounded-lg object-cover shrink-0">

                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900 leading-tight">
                                        {{ $nombreCliente }}
                                    </h4>
                                    <p class="text-xs text-gray-400">
                                        {{ $fecha }}
                                    </p>
                                </div>

                                <div class="flex text-[#3d50ff] text-xs">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa-solid fa-star mx-0.5
                                            {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}">
                                        </i>
                                    @endfor
                                </div>
                            </div>

                            <p class="mt-3 text-sm text-gray-600 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($comentario, 160) }}
                            </p>

                            @if($review->producto)
                                <p class="mt-2 text-xs text-gray-400">
                                    Producto reseñado:
                                    <span class="font-semibold text-gray-700">
                                        {{ $review->producto->nombre_producto }}
                                    </span>
                                </p>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">
                        Aún no hay reseñas publicadas. ¡Pronto verás aquí opiniones de nuestros clientes!
                    </p>
                @endforelse

            </div>

        </div>
    </section>

</div>

<script>
    // -----------------------------
    // CARRUSEL: FLUIDO Y SIN TRABAS
    // -----------------------------
    document.addEventListener('DOMContentLoaded', () => {
        const carousel = document.getElementById('carouselProducts');
        const btnLeft  = document.getElementById('btnLeft');
        const btnRight = document.getElementById('btnRight');

        if (!carousel || !btnLeft || !btnRight) return;

        // Paso: ancho de tarjeta + espacio
        const getStep = () => {
            const card = carousel.querySelector('article');
            if (!card) return 300;
            const rect = card.getBoundingClientRect();
            return rect.width + 32; // 32px ≈ gap-8
        };

        let isScrolling = false;
        const doScroll = (direction) => {
            if (isScrolling) return;      // evita doble click rápido
            isScrolling = true;

            carousel.scrollBy({
                left: direction * getStep(),
                behavior: 'smooth'
            });

            setTimeout(() => {
                isScrolling = false;
            }, 400); // tiempo parecido a la animación del scroll
        };

        btnRight.addEventListener('click', () => {
            doScroll(1);   // derecha
        });

        btnLeft.addEventListener('click', () => {
            const step = getStep();
            const nuevoScroll = carousel.scrollLeft - step;

            carousel.scrollTo({
                left: nuevoScroll < 0 ? 0 : nuevoScroll,
                behavior: 'smooth'
            });
        });
    });

    // -----------------------------
    // CARGA DE IMÁGENES
    // -----------------------------
    window.loadProductImage = function(productId) {
        const component = document.querySelector(`[data-product-id="${productId}"]`);
        if (!component || !component._x_dataStack) return;

        const data = component._x_dataStack[0];
        const apiUrl = `/api/imagenes/producto/${productId}/principal`;

        fetch(apiUrl)
            .then(response => response.json())
            .then(result => {
                if (result.success && result.data && result.data.url_completa) {
                    data.product.image = result.data.url_completa;
                } else {
                    data.product.image = '/img/placeholder.png';
                }
            })
            .catch(() => {
                data.product.image = '/img/placeholder.png';
            });
    };

    document.addEventListener('alpine:init', () => {
        setTimeout(() => {
            document.querySelectorAll('[data-product-id]').forEach(element => {
                const productId = element.getAttribute('data-product-id');
                if (productId) loadProductImage(productId);
            });
        }, 200);
    });
</script>
@endsection
