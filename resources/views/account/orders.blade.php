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

                {{-- Órdenes (ACTIVO) --}}
                <a href="{{ route('account.orders') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                          border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold">
                    <span>Órdenes</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                {{-- Reseñas --}}
                 <a href="{{ route('account.reviews') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 border-transparent text-gray-600 hover:bg-gray-50">
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

        {{-- CONTENIDO: ÓRDENES --}}
        <section class="bg-white rounded-3xl shadow-sm p-6 md:p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                <div>
                    <h1 class="text-2xl font-bold text-[#2128A6]">Órdenes</h1>
                    <p class="text-sm text-gray-500">
                        Revisa el historial de tus compras en Nexus.
                    </p>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                             bg-emerald-100 text-emerald-700">
                    Datos de ejemplo (lista para conectar a BD)
                </span>
            </div>

            {{-- TABLA desktop --}}
            <div class="hidden md:block mt-8">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                            <th class="text-left py-3">Orden</th>
                            <th class="text-left py-3">Fecha</th>
                            <th class="text-left py-3">Estado</th>
                            <th class="text-right py-3">Total</th>
                            <th class="text-right py-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @foreach($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 font-semibold text-gray-900">{{ $order['code'] }}</td>
                            <td class="py-3 text-gray-600">{{ $order['date'] }}</td>

                            <td class="py-3">
                                @php
                                    $color = [
                                        'Completada' => 'bg-emerald-100 text-emerald-700',
                                        'En proceso' => 'bg-amber-100 text-amber-700',
                                        'Cancelada'  => 'bg-rose-100 text-rose-700',
                                    ][$order['status']];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $color }}">
                                    {{ $order['status'] }}
                                </span>
                            </td>

                            <td class="py-3 text-right font-semibold text-gray-900">
                                {{ $order['total'] }}
                            </td>

                            <td class="py-3 text-right">
                                <button class="text-xs px-3 py-1 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                                    Ver detalle
                                </button>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- Versión móvil --}}
            <div class="md:hidden mt-6 space-y-4">
                @foreach($orders as $order)
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 space-y-2">
                        <p class="font-semibold text-gray-900">{{ $order['code'] }}</p>
                        <p class="text-xs text-gray-500">Fecha: <span class="font-medium">{{ $order['date'] }}</span></p>
                        <p class="text-xs text-gray-500">Total: <span class="font-semibold text-gray-900">{{ $order['total'] }}</span></p>

                        @php
                            $color = [
                                'Completada' => 'bg-emerald-100 text-emerald-700',
                                'En proceso' => 'bg-amber-100 text-amber-700',
                                'Cancelada'  => 'bg-rose-100 text-rose-700',
                            ][$order['status']];
                        @endphp
                        <span class="inline-block px-2 py-1 text-xs rounded-full {{ $color }}">
                            {{ $order['status'] }}
                        </span>

                        <button class="w-full mt-2 text-xs px-3 py-2 rounded-full border border-[#2128A6] text-[#2128A6] hover:bg-[#2128A6] hover:text-white transition">
                            Ver detalle
                        </button>
                    </div>
                @endforeach
            </div>

        </section>

    </div>
</div>
@endsection
