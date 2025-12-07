@extends('layouts.app')

@section('content')
<div class="bg-[#f4f6fb] min-h-[calc(100vh-80px)] py-10">
    <div class="max-w-6xl mx-auto px-4 md:px-0 grid md:grid-cols-[280px,1fr] gap-8">

        {{-- SIDEBAR MI CUENTA --}}
        <aside class="bg-white rounded-3xl shadow-sm overflow-hidden h-fit">

            {{-- Cabecera usuario --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-full bg-[#6F73BF]/10 flex items-center justify-center text-[#6F73BF] font-semibold">
                    A
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-gray-900">User Demo</p>
                    <p class="text-gray-500 text-xs">user@correo.com</p>
                </div>
            </div>

            {{-- Menú lateral --}}
            <nav class="text-sm">
                <p class="px-6 pt-4 pb-2 text-[11px] font-semibold tracking-wide text-gray-400 uppercase">
                    Mi cuenta
                </p>

                {{-- Perfil --}}
                <a href="{{ route('account.profile') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                    {{ request()->routeIs('account.profile') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Perfil</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Dirección --}}
                <a href="{{ route('account.address') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                    {{ request()->routeIs('account.address') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Dirección</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Órdenes --}}
                <a href="{{ route('account.orders') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                    {{ request()->routeIs('account.orders') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Órdenes</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Reseñas (ACTIVO) --}}
                <a href="{{ route('account.reviews') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                          border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold">
                    <span>Reseñas</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Favoritos --}}
                <a href="{{ route('account.favorites') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 border-transparent text-gray-600 hover:bg-gray-50">
                    <span>Favoritos</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>
            </nav>
        </aside>

        {{-- CONTENIDO: RESEÑAS --}}
        <section class="bg-white rounded-3xl shadow-sm p-6 md:p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div>
                    <h1 class="text-2xl font-bold text-[#2128A6]">Reseñas</h1>
                    <p class="text-sm text-gray-500">
                        Revisa y gestiona tus reseñas de productos.
                    </p>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                             bg-emerald-100 text-emerald-700">
                    Datos de ejemplo (listo para conectar a BD)
                </span>
            </div>

            {{-- LISTA desktop --}}
            <div class="hidden md:block mt-8">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                            <th class="text-left py-3">Producto</th>
                            <th class="text-left py-3">Fecha</th>
                            <th class="text-left py-3">Valoración</th>
                            <th class="text-left py-3">Comentario</th>
                            <th class="text-right py-3">Estado</th>
                            <th class="text-right py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @foreach($reviews as $review)
                        <tr class="hover:bg-gray-50 align-top">
                            {{-- Producto --}}
                            <td class="py-3 font-semibold text-gray-900">
                                {{ $review['product'] }}
                            </td>

                            {{-- Fecha --}}
                            <td class="py-3 text-gray-600 whitespace-nowrap">
                                {{ $review['date'] }}
                            </td>

                            {{-- Valoración --}}
                            <td class="py-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star text-xs 
                                        {{ $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </td>

                            {{-- Comentario --}}
                            <td class="py-3 text-gray-600 max-w-xs">
                                {{ $review['comment'] }}
                            </td>

                            {{-- Estado --}}
                            <td class="py-3 text-right">
                                @php
                                    $badge = $review['status'] === 'Publicado'
                                        ? 'bg-emerald-100 text-emerald-700'
                                        : 'bg-amber-100 text-amber-700';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }}">
                                    {{ $review['status'] }}
                                </span>
                            </td>

                            {{-- Acción --}}
                            <td class="py-3 text-right space-x-2 whitespace-nowrap">
                                <button class="text-xs px-3 py-1 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                                    Ver producto
                                </button>
                                <button class="text-xs px-3 py-1 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                                    Editar
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- Versión móvil --}}
            <div class="md:hidden mt-6 space-y-4">
                @foreach($reviews as $review)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 space-y-2">
                        <p class="font-semibold text-gray-900">{{ $review['product'] }}</p>
                        <p class="text-xs text-gray-500">
                            Fecha:
                            <span class="font-medium">{{ $review['date'] }}</span>
                        </p>

                        <div class="flex items-center gap-1 text-xs">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star 
                                    {{ $i <= $review['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>

                        <p class="text-xs text-gray-600">
                            {{ $review['comment'] }}
                        </p>

                        @php
                            $badge = $review['status'] === 'Publicado'
                                ? 'bg-emerald-100 text-emerald-700'
                                : 'bg-amber-100 text-amber-700';
                        @endphp
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $badge }}">
                            {{ $review['status'] }}
                        </span>

                        <div class="flex gap-2 mt-2">
                            <button class="flex-1 text-xs px-3 py-2 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                                Ver producto
                            </button>
                            <button class="flex-1 text-xs px-3 py-2 rounded-full border border-gray-300 text-gray-600 hover:bg-gray-100 transition">
                                Editar
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>

    </div>
</div>
@endsection
