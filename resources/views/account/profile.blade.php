@extends('layouts.app')

@section('no_footer', '1') {{-- ocultar footer en esta página --}}

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12">

    @php
        // Valores que vienen del controlador (+ old() por si falla la validación)
        $firstName  = old('first_name', $firstName ?? '');
        $lastName   = old('last_name', $lastName ?? '');
        $email      = old('email', $user->correo_electronico ?? '');
        $phone      = old('phone', $user->telefono ?? '');
        $avatarChar = mb_substr($user->nombre_completo ?? 'U', 0, 1);
    @endphp

    <div class="max-w-6xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">

        {{-- COLUMNA IZQUIERDA: MENÚ MI CUENTA --}}
        <aside class="bg-white rounded-2xl shadow-lg overflow-hidden md:col-span-1 min-h-[60vh]">
            {{-- CABECERA USUARIO --}}
            <div class="flex items-center gap-4 px-7 py-6 border-b border-gray-100">
                <div class="w-14 h-14 rounded-full bg-[#6F73BF]/10 flex items-center justify-center text-[#2128A6] text-2xl font-semibold">
                    {{ $avatarChar }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">
                        {{ $user->nombre_completo ?? 'Usuario' }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $user->correo_electronico ?? 'correo@ejemplo.com' }}
                    </p>
                </div>
            </div>

            {{-- TÍTULO MI CUENTA --}}
            <div class="px-7 pt-5 pb-3">
                <p class="text-xs uppercase tracking-wide text-gray-400">
                    Mi cuenta
                </p>
            </div>

            {{-- MENÚ LATERAL --}}
            <nav class="flex flex-col text-base">
                <a href="{{ route('account.profile') }}"
                   class="flex items-center justify-between px-7 py-3.5 font-medium
                          bg-[#f4f6fb] text-[#2128A6] border-l-4 border-[#2128A6]">
                    <span>Perfil</span>
                    <span class="text-xs">&gt;</span>
                </a>

                <a href="{{ route('account.address') }}"
                   class="flex items-center justify-between px-7 py-3.5 text-gray-600 hover:bg-gray-50">
                    <span>Dirección</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                <a href="{{ route('account.orders') }}"
                   class="flex items-center justify-between px-7 py-3.5 text-gray-600 hover:bg-gray-50">
                    <span>Órdenes</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                <a href="{{ route('account.reviews') }}"
                   class="flex items-center justify-between px-7 py-3.5 text-gray-600 hover:bg-gray-50">
                    <span>Reseñas</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                <a href="{{ route('account.favorites') }}"
                   class="flex items-center justify-between px-7 py-3.5 text-gray-600 hover:bg-gray-50">
                    <span>Favoritos</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>
            </nav>
        </aside>

        {{-- COLUMNA DERECHA: FORMULARIO DE PERFIL --}}
        <section class="bg-white rounded-2xl shadow-lg p-8 lg:p-10 md:col-span-2 min-h-[60vh]">

            {{-- Mensaje de estado --}}
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Errores de validación --}}
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-[#2128A6]">Perfil</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Revisa y edita tus datos personales.
                    </p>
                </div>
                <button
                    type="button"
                    class="px-6 py-2.5 rounded-full border border-[#6F73BF] text-[#6F73BF]
                           text-sm font-semibold cursor-default">
                    Editar
                </button>
            </div>

            {{-- FORMULARIO --}}
            <form action="{{ route('account.profile.update') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid md:grid-cols-2 gap-7">
                    <div class="space-y-1">
                        <label for="first_name" class="text-xs text-gray-400 uppercase tracking-wide">
                            Primer nombre
                        </label>
                        <input
                            type="text"
                            id="first_name"
                            name="first_name"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800 outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ $firstName }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="last_name" class="text-xs text-gray-400 uppercase tracking-wide">
                            Primer apellido
                        </label>
                        <input
                            type="text"
                            id="last_name"
                            name="last_name"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800 outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ $lastName }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="birth_date" class="text-xs text-gray-400 uppercase tracking-wide">
                            Fecha de nacimiento
                        </label>
                        <input
                            type="date"
                            id="birth_date"
                            name="birth_date"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800 outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('birth_date') }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="phone" class="text-xs text-gray-400 uppercase tracking-wide">
                            Número de teléfono
                        </label>
                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800 outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ $phone }}"
                        >
                    </div>

                    <div class="space-y-1 md:col-span-2">
                        <label for="email" class="text-xs text-gray-400 uppercase tracking-wide">
                            Correo electrónico
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800 outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ $email }}"
                        >
                    </div>
                </div>

                <div class="flex justify-between items-center pt-2">
                    <button
                        type="submit"
                        class="px-7 py-2.5 rounded-full bg-[#2128A6] text-white text-sm font-semibold
                               hover:bg-[#151c7a] transition">
                        Guardar cambios
                    </button>

                    <button
                        type="button"
                        class="px-7 py-2.5 rounded-full border border-red-300 text-red-500 text-sm font-semibold
                               hover:bg-red-50 transition">
                        Eliminar cuenta
                    </button>
                </div>
            </form>
        </section>

    </div>
</div>
@endsection
