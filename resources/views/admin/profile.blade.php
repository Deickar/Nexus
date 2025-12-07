@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    {{--
    |--------------------------------------------------------------------------
    | Encabezado de la Página de Perfil
    |--------------------------------------------------------------------------
    |
    | Título principal y botones de acción para la página de edición de perfil.
    | Incluye un botón para "Atrás" y otro para "Guardar cuenta".
    |
    --}}
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold">Mi cuenta</h1>
        <div>
            <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Atrás</a>
            <button form="profile-form" type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Guardar cuenta
            </button>
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | Formulario de Perfil
    |--------------------------------------------------------------------------
    |
    | Formulario dividido en dos secciones principales:
    | 1. Información de la cuenta (imagen, nombre, correo).
    | 2. Cambio de contraseña.
    | Utiliza un grid para organizar las secciones una al lado de la otra en
    | pantallas grandes.
    |
    --}}
    <form id="profile-form" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{--
            |------------------------------------------------------------------
            | Sección 1: Datos de la Cuenta
            |------------------------------------------------------------------
            |
            | Ocupa dos de las tres columnas en pantallas grandes.
            | Contiene los campos para la imagen de perfil, nombres y correo.
            |
            --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Información de la cuenta</h2>
                    
                    {{-- Campo para la Imagen de Perfil --}}
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Imagen de Perfil
                        </label>
                        <div class="flex items-center">
                            <div class="w-24 h-24 rounded-full bg-gray-200 mr-4 flex items-center justify-center">
                                {{-- TODO: Mostrar la imagen actual del usuario si existe --}}
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="file" name="profile_image" id="profile_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    {{-- Campo para Nombres --}}
                    <div class="mb-6">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                            Nombres*
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>

                    {{-- Campo para Correo --}}
                    <div>
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                            Correo*
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    </div>
                </div>
            </div>

            {{--
            |------------------------------------------------------------------
            | Sección 2: Cambio de Contraseña
            |------------------------------------------------------------------
            |
            | Ocupa una de las tres columnas en pantallas grandes.
            | Contiene los campos para la contraseña actual, la nueva
            | contraseña y su confirmación.
            |
            --}}
            <div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-6">Cambiar contraseña</h2>

                    {{-- Campo para Contraseña Actual --}}
                    <div class="mb-6">
                        <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">
                            Contraseña actual*
                        </label>
                        <input type="password" name="current_password" id="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    {{-- Campo para Nueva Contraseña --}}
                    <div class="mb-6">
                        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                            Contraseña
                        </label>
                        <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    {{-- Campo para Confirmar Nueva Contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">
                            Confirmar contraseña*
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
