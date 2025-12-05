@extends('layouts.app')

@section('content')
<div class="bg-[#f4f6fb] py-16">
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-md px-8 md:px-12 py-10">

        {{-- TÍTULO --}}
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#2128A6] mb-2">
            Contacta con nosotros
        </h1>
        <p class="text-sm text-gray-500 mb-8">
            Escríbenos y te responderemos lo antes posible.
        </p>

        {{-- FORMULARIO --}}
        <form action="#" method="POST" class="space-y-6">
            @csrf

            {{-- NOMBRE --}}
            <div>
                <label for="name" class="block text-sm font-semibold text-[#2128A6] mb-1">
                    Nombre *
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Nombre"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                           text-sm text-gray-800 bg-[#f9fafb]
                           focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                    required
                >
            </div>

            {{-- CORREO --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-[#2128A6] mb-1">
                    Correo *
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="correo"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                           text-sm text-gray-800 bg-[#f9fafb]
                           focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                    required
                >
            </div>

            {{-- TELÉFONO --}}
            <div>
                <label for="phone" class="block text-sm font-semibold text-[#2128A6] mb-1">
                    Número teléfono *
                </label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    placeholder="número de teléfono"
                    class="w-full rounded-xl border border-gray-300 px-4 py-2.5
                           text-sm text-gray-800 bg-[#f9fafb]
                           focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                    required
                >
            </div>

            {{-- MENSAJE --}}
            <div>
                <label for="message" class="block text-sm font-semibold text-[#2128A6] mb-1">
                    ¿Qué tienes en mente? *
                </label>
                <textarea
                    id="message"
                    name="message"
                    rows="5"
                    placeholder="Escribe aquí"
                    class="w-full rounded-xl border border-gray-300 px-4 py-3
                           text-sm text-gray-800 bg-[#f9fafb]
                           focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                    required
                ></textarea>
            </div>

            {{-- BOTÓN ENVIAR --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full md:w-40 inline-flex items-center justify-center
                           bg-[#30D9C8] hover:bg-[#77D9CF]
                           text-white font-semibold text-sm md:text-base
                           px-6 py-2.5 rounded-full shadow-md transition">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection