@extends('layouts.app')

@section('content')

<section class="bg-[#f4f6fb] py-16">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#2128A6] mb-4">
            🎈Ofertas del Día🎉
        </h1>

        <p class="text-center text-gray-600 mb-12">
            Aprovecha las promociones exclusivas disponibles por tiempo limitado.
        </p>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

            {{-- TARJETA 1 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/audifonos.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -20%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Audífonos inalámbricos</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q499</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q399</span>
                </div>
            </div>

            {{-- TARJETA 2 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/lenovolaptop.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#30D9C8] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        Nuevo precio
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Laptop Lenovo 14"</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q5,999</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q4,999</span>
                </div>
            </div>

            {{-- TARJETA 3 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/perfumehugoboss.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        2x1
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Perfume edición especial</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-[#30D9C8] font-bold text-lg">Q299</span>
                </div>
            </div>

            {{-- TARJETA 4 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/zapatozara.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -10%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Zapatillas urbanas</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q799</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q719</span>
                </div>
            </div>

            {{-- TARJETA 5 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/tabk10.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -5%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Tablet Xiaomi</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q335</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q319</span>
                </div>
            </div>

            {{-- TARJETA 6 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/dulce.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -5%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Chicle</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q2</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q1</span>
                </div>
            </div>

        </div> {{-- fin grid --}}

        <div class="text-center mt-12">
            <p class="text-gray-700 mb-4">¡No te quedes sin aprovechar estas promociones!</p>

            <a href="#" class="inline-block bg-gradient-to-r from-[#30D9C8] to-[#77D9CF] text-white px-8 py-3 rounded-full text-lg font-semibold shadow-md hover:scale-[1.03] transition">
                Comprar ahora
            </a>
        </div>

    </div>
</section>

@endsection
