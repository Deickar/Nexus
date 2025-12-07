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

                {{-- Reseñas --}}
                <a href="{{ route('account.reviews') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4
                    {{ request()->routeIs('account.reviews') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Reseñas</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Favoritos (ACTIVO) --}}
                <a href="{{ route('account.favorites') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4
                          border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold">
                    <span>Favoritos</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>
            </nav>
        </aside>

        {{-- CONTENIDO: FAVORITOS --}}
        <section class="bg-white rounded-3xl shadow-sm p-6 md:p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#2128A6]">Favoritos</h1>
                    <p class="text-sm text-gray-500">
                        Productos que guardaste para revisar o comprar después.
                    </p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                             bg-emerald-100 text-emerald-700">
                    Datos de ejemplo (lista para conectar a BD)
                </span>
            </div>

            {{-- Desktop: lista tipo tabla --}}
            <div class="hidden md:block">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                            <th class="text-left py-3">Producto</th>
                            <th class="text-left py-3">Categoría</th>
                            <th class="text-left py-3">Añadido</th>
                            <th class="text-right py-3">Precio</th>
                            <th class="text-right py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($favorites as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $item['image'] }}" class="w-12 h-12 rounded-lg object-cover" alt="{{ $item['name'] }}">
                                        <span class="font-semibold text-gray-900">{{ $item['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 text-gray-600">
                                    {{ $item['category'] }}
                                </td>
                                <td class="py-3 text-gray-600">
                                    {{ $item['added_at'] }}
                                </td>
                                <td class="py-3 text-right font-semibold text-gray-900">
                                    {{ $item['price'] }}
                                </td>
                                <td class="py-3 text-right space-x-2">
                                    <button class="text-xs px-3 py-1 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                                        Ver producto
                                    </button>
                                    <button class="text-xs px-3 py-1 rounded-full border border-rose-300 text-rose-500 hover:bg-rose-50 transition">
                                        Quitar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Móvil: tarjetas --}}
            <div class="md:hidden space-y-4">
                @foreach($favorites as $item)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 flex gap-3">
                        <img src="{{ $item['image'] }}" class="w-16 h-16 rounded-lg object-cover flex-shrink-0" alt="{{ $item['name'] }}">
                        <div class="flex-1 space-y-1">
                            <p class="font-semibold text-gray-900 text-sm">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $item['category'] }}</p>
                            <p class="text-xs text-gray-500">
                                Añadido: <span class="font-medium">{{ $item['added_at'] }}</span>
                            </p>
                            <p class="text-sm font-semibold text-[#2128A6] mt-1">
                                {{ $item['price'] }}
                            </p>

                            <div class="flex gap-2 mt-2">
                                <button class="flex-1 text-xs px-3 py-2 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                                    Ver producto
                                </button>
                                <button class="text-xs px-3 py-2 rounded-full border border-rose-300 text-rose-500 hover:bg-rose-50 transition">
                                    Quitar
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </section>

    </div>
</div>
@endsection
