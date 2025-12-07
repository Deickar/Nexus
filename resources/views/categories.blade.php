@extends('layouts.app')

@section('content')

{{-- SECCIÓN PRINCIPAL --}}
<section class="bg-[#f4f6fb] py-16">

    <div class="max-w-7xl mx-auto px-6">

        {{-- TÍTULO --}}
        <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#2128A6] mb-12">
            Categorías
        </h1>

      
         @php
    $categories = [
        ['name' => 'Belleza',    'icon' => 'ph-flower',        'slug' => 'belleza'],
        ['name' => 'Oficina',    'icon' => 'ph-briefcase',       'slug' => 'oficina'],
        ['name' => 'Hogar',      'icon' => 'ph-house',           'slug' => 'hogar'],
        ['name' => 'Niños',      'icon' => 'ph-baby',            'slug' => 'niños'],
        ['name' => 'Deportes',   'icon' => 'ph-basketball',      'slug' => 'deportes'],
        ['name' => 'Juguetes',   'icon' => 'ph-game-controller', 'slug' => 'juguetes'],
        ['name' => 'Tecnología', 'icon' => 'ph-device-mobile',   'slug' => 'tecnologia'],
        ['name' => 'Ropa',       'icon' => 'ph-dress',           'slug' => 'ropa'],
    ];
        @endphp

        {{-- GRID DE CATEGORÍAS --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-10">

            @foreach($categories as $category)
                <a href="{{ route('category.show', $category['slug']) }}" 
   class="flex flex-col items-center gap-3 cursor-pointer group">

<div class="w-24 h-24 bg-white rounded-2xl shadow-md flex items-center justify-center
            group-hover:scale-[1.05] group-hover:shadow-lg transition">

    <i class="ph {{ $category['icon'] }} text-5xl text-[#2128A6]"></i>

</div>




    <p class="text-center text-lg font-semibold text-gray-700">
        {{ $category['name'] }}
    </p>

</a>

            @endforeach

        </div>

    </div>

</section>

@endsection
