@extends('layouts.app')

@section('no_footer', '1') {{-- ocultar footer en esta página --}}

@section('content')
<div class="bg-[#f4f6fb] min-h-screen py-12">

    <div class="max-w-6xl mx-auto px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-10">

        {{-- COLUMNA IZQUIERDA: MENÚ MI CUENTA --}}
        <aside class="bg-white rounded-2xl shadow-lg overflow-hidden md:col-span-1 min-h-[60vh]">
            {{-- CABECERA USUARIO --}}
            <div class="flex items-center gap-4 px-7 py-6 border-b border-gray-100">
                <div class="w-14 h-14 rounded-full bg-[#6F73BF]/10 flex items-center justify-center text-[#2128A6] text-2xl font-semibold">
                    A
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">User Demo</p>
                    <p class="text-xs text-gray-500">user@correo.com</p>
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
                   class="flex items-center justify-between px-7 py-3.5 text-gray-600 hover:bg-gray-50">
                    <span>Perfil</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                <a href="{{ route('account.address') }}"
                   class="flex items-center justify-between px-7 py-3.5 font-medium
                          bg-[#f4f6fb] text-[#2128A6] border-l-4 border-[#2128A6]">
                    <span>Dirección</span>
                    <span class="text-xs">&gt;</span>
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

        {{-- COLUMNA DERECHA: FORMULARIO DE DIRECCIÓN --}}
        <section class="bg-white rounded-2xl shadow-lg p-8 lg:p-10 md:col-span-2 min-h-[60vh]">

            {{-- Mensaje de estado (demo) --}}
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
                    <h1 class="text-3xl font-extrabold text-[#2128A6]">Dirección</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Gestiona las direcciones donde recibirás tus pedidos.
                    </p>
                </div>
                <button
                    type="submit"
                    form="address-form"
                    class="px-6 py-2.5 rounded-full bg-[#2128A6] text-white text-sm font-semibold
                           hover:bg-[#151c7a] transition">
                    Guardar cambios
                </button>
            </div>

            {{-- FORMULARIO --}}
            <form id="address-form"
                  action="{{ route('account.address.update') }}"
                  method="POST"
                  class="space-y-8">
                @csrf

                <div class="grid md:grid-cols-2 gap-7">
                    <div class="space-y-1 md:col-span-2">
                        <label for="street" class="text-xs text-gray-400 uppercase tracking-wide">
                            Calle y avenida
                        </label>
                        <input
                            type="text"
                            id="street"
                            name="street"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('street', '4a calle') }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="number" class="text-xs text-gray-400 uppercase tracking-wide">
                            Número / Casa / Apto
                        </label>
                        <input
                            type="text"
                            id="number"
                            name="number"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('number', '#12-34') }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="city" class="text-xs text-gray-400 uppercase tracking-wide">
                            Ciudad / Municipio
                        </label>
                        <input
                            type="text"
                            id="city"
                            name="city"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('city', 'Guatemala') }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="department" class="text-xs text-gray-400 uppercase tracking-wide">
                            Departamento
                        </label>
                        <input
                            type="text"
                            id="department"
                            name="department"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('department', 'Guatemala') }}"
                        >
                    </div>

                    <div class="space-y-1">
                        <label for="postal_code" class="text-xs text-gray-400 uppercase tracking-wide">
                            Código postal
                        </label>
                        <input
                            type="text"
                            id="postal_code"
                            name="postal_code"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF]"
                            value="{{ old('postal_code', '01001') }}"
                        >
                    </div>

                    <div class="space-y-1 md:col-span-2">
                        <label for="reference" class="text-xs text-gray-400 uppercase tracking-wide">
                            Referencias (cómo llegar)
                        </label>
                        <textarea
                            id="reference"
                            name="reference"
                            rows="3"
                            class="w-full bg-[#f4f6fb] rounded-lg px-4 py-3 text-sm text-gray-800
                                   outline-none border border-transparent focus:border-[#6F73BF] resize-none"
                        >{{ old('reference', 'Frente a la tienda azul, portón blanco.') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        type="submit"
                        class="px-7 py-2.5 rounded-full bg-[#2128A6] text-white text-sm font-semibold
                               hover:bg-[#151c7a] transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </section>

    </div>
</div>
@endsection