@extends('layouts.app')

@section('content')

<section class="bg-[#f4f6fb] py-16">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-extrabold text-[#2128A6] mb-6 text-center">
            Categoría: {{ ucfirst($slug) }}
        </h1>

        @if (count($products) === 0)
            <p class="text-center text-gray-600 text-lg">
                Por ahora no hay productos en esta categoría.
            </p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mt-10">

                @foreach ($products as $p)
                    <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">

                        <div class="relative h-32 rounded-xl overflow-hidden mb-4 bg-[#f4f6fb] flex items-center justify-center">
                            <img src="{{ $p['img'] }}" class="max-h-28 object-contain" alt="{{ $p['name'] }}">
                        </div>

                        <h3 class="text-lg font-semibold text-gray-800">
                            {{ $p['name'] }}
                        </h3>

                        <p class="text-[#30D9C8] font-bold text-xl mt-2">
                            Q{{ $p['price'] }}
                        </p>

                        {{-- BOTÓN AGREGAR AL CARRITO --}}
                    <button
    class="mt-4 w-full bg-[#6C6BEF] text-white py-2 rounded-xl font-semibold
           hover:bg-[#5a59d6] active:bg-[#4a48b8] transition"
    @click="$dispatch('add-to-cart', {
        id: {{ $loop->index }}, // o el id real del producto
        name: '{{ $p['name'] }}',
        price: {{ $p['price'] }},
        img: '{{ $p['img'] }}'
    })"
>
    Añadir al carrito
</button>


                    </div>
                @endforeach

            </div>
        @endif

    </div>
</section>

@endsection
