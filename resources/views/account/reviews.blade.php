@extends('layouts.app')

@section('content')
<div class="bg-[#f4f6fb] min-h-[calc(100vh-80px)] py-10">
    <div class="max-w-6xl mx-auto px-4 md:px-0 grid md:grid-cols-[280px,1fr] gap-8">

        {{-- SIDEBAR MI CUENTA --}}
        <aside class="bg-white rounded-3xl shadow-sm overflow-hidden h-fit">

            {{-- Cabecera usuario (puedes sustituir con datos reales si quieres) --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                <div class="w-11 h-11 rounded-full bg-[#6F73BF]/10 flex items-center justify-center text-[#6F73BF] font-semibold">
                    {{ strtoupper(substr(auth()->user()->nombre_completo ?? 'U', 0, 1)) }}
                </div>
                <div class="text-sm">
                    <p class="font-semibold text-gray-900">
                        {{ auth()->user()->nombre_completo ?? 'Usuario' }}
                    </p>
                    <p class="text-gray-500 text-xs">
                        {{ auth()->user()->correo_electronico ?? 'correo@correo.com' }}
                    </p>
                </div>
            </div>

            {{-- Menú lateral --}}
            <nav class="text-sm">
                <p class="px-6 pt-4 pb-2 text-[11px] font-semibold tracking-wide text-gray-400 uppercase">
                    Mi cuenta
                </p>

                <a href="{{ route('account.profile') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                    {{ request()->routeIs('account.profile') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Perfil</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

                <a href="{{ route('account.address') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 
                    {{ request()->routeIs('account.address') ? 'border-[#3d50ff] bg-[#f4f6fb] text-[#2128A6] font-semibold' : 'border-transparent text-gray-600 hover:bg-gray-50' }}">
                    <span>Dirección</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>

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

                <a href="{{ route('account.favorites') }}"
                   class="flex items-center justify-between px-6 py-3 border-l-4 border-transparent text-gray-600 hover:bg-gray-50">
                    <span>Favoritos</span>
                    <span class="text-xs text-gray-400">&gt;</span>
                </a>
            </nav>
        </aside>

        {{-- CONTENIDO: RESEÑAS --}}
        <section class="bg-white rounded-3xl shadow-sm p-6 md:p-8">

            {{-- Mensajes de estado --}}
            @if (session('status'))
                <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('status_error'))
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ session('status_error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-[#2128A6]">Reseñas</h1>
                    <p class="text-sm text-gray-500">
                        Revisa y gestiona tus reseñas de productos.
                    </p>
                </div>

                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-medium
                             bg-emerald-100 text-emerald-700">
                    Tienes {{ $reviews->total() }} reseña(s)
                </span>
            </div>

            {{-- FORMULARIO: NUEVA RESEÑA --}}
            <div class="mb-8 border border-gray-100 rounded-2xl p-4 md:p-5 bg-[#f9fafb]">
                <h2 class="text-sm font-semibold text-[#2128A6] mb-3">
                    Crear nueva reseña
                </h2>

                <form action="{{ route('account.reviews.store') }}" method="POST" class="space-y-4">
                    @csrf

                    {{-- Producto --}}
                    <div class="grid md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs text-gray-500 uppercase tracking-wide">
                                Producto *
                            </label>
                            <select
                                name="id_producto"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                                required
                            >
                                <option value="">Selecciona un producto</option>
                                @foreach($productos as $producto)
                                    <option value="{{ $producto->id_producto }}"
                                        {{ old('id_producto') == $producto->id_producto ? 'selected' : '' }}>
                                        {{ $producto->nombre_producto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Rating --}}
                        <div class="space-y-1">
                            <label class="text-xs text-gray-500 uppercase tracking-wide">
                                Valoración *
                            </label>
                            <select
                                name="rating"
                                class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                                required
                            >
                                <option value="">Selecciona</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                        {{ $i }} estrella{{ $i > 1 ? 's' : '' }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Comentario --}}
                    <div class="space-y-1">
                        <label class="text-xs text-gray-500 uppercase tracking-wide">
                            Comentario (opcional)
                        </label>
                        <textarea
                            name="comment"
                            rows="3"
                            class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#6F73BF] focus:border-[#6F73BF]"
                            placeholder="Cuéntanos tu experiencia con el producto"
                        >{{ old('comment') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-6 py-2.5 rounded-full bg-[#2128A6] text-white text-xs md:text-sm font-semibold hover:bg-[#151c7a] transition"
                        >
                            Enviar reseña
                        </button>
                    </div>
                </form>
            </div>

            {{-- LISTA desktop --}}
            @if($reviews->count() > 0)
                <div class="hidden md:block mt-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-xs text-gray-500 uppercase border-b border-gray-100">
                                <th class="text-left py-3">Producto</th>
                                <th class="text-left py-3">Fecha</th>
                                <th class="text-left py-3">Valoración</th>
                                <th class="text-left py-3">Comentario</th>
                                <th class="text-right py-3">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">

                            @foreach($reviews as $review)
                                @php
                                    $productoNombre = $review->producto->nombre_producto ?? 'Producto no disponible';

                                    switch ($review->status) {
                                        case \App\Models\Review::STATUS_APPROVED:
                                            $statusText = 'Publicado';
                                            $badgeClass = 'bg-emerald-100 text-emerald-700';
                                            break;
                                        case \App\Models\Review::STATUS_PENDING:
                                            $statusText = 'Pendiente';
                                            $badgeClass = 'bg-amber-100 text-amber-700';
                                            break;
                                        case \App\Models\Review::STATUS_REJECTED:
                                            $statusText = 'Rechazado';
                                            $badgeClass = 'bg-red-100 text-red-700';
                                            break;
                                        default:
                                            $statusText = 'Desconocido';
                                            $badgeClass = 'bg-gray-100 text-gray-600';
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50 align-top">
                                    {{-- Producto --}}
                                    <td class="py-3 font-semibold text-gray-900">
                                        {{ $productoNombre }}
                                    </td>

                                    {{-- Fecha --}}
                                    <td class="py-3 text-gray-600 whitespace-nowrap">
                                        {{ optional($review->review_date)->format('d/m/Y') }}
                                    </td>

                                    {{-- Valoración --}}
                                    <td class="py-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fa-solid fa-star text-xs 
                                                {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </td>

                                    {{-- Comentario --}}
                                    <td class="py-3 text-gray-600 max-w-xs">
                                        {{ $review->comment ?? 'Sin comentario' }}
                                    </td>

                                    {{-- Estado --}}
                                    <td class="py-3 text-right">
                                        <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $badgeClass }}">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $reviews->links() }}
                    </div>
                </div>

                {{-- Versión móvil --}}
                <div class="md:hidden mt-4 space-y-4">
                    @foreach($reviews as $review)
                        @php
                            $productoNombre = $review->producto->nombre_producto ?? 'Producto no disponible';

                            switch ($review->status) {
                                case \App\Models\Review::STATUS_APPROVED:
                                    $statusText = 'Publicado';
                                    $badgeClass = 'bg-emerald-100 text-emerald-700';
                                    break;
                                case \App\Models\Review::STATUS_PENDING:
                                    $statusText = 'Pendiente';
                                    $badgeClass = 'bg-amber-100 text-amber-700';
                                    break;
                                case \App\Models\Review::STATUS_REJECTED:
                                    $statusText = 'Rechazado';
                                    $badgeClass = 'bg-red-100 text-red-700';
                                    break;
                                default:
                                    $statusText = 'Desconocido';
                                    $badgeClass = 'bg-gray-100 text-gray-600';
                            }
                        @endphp

                        <div class="rounded-2xl border border-gray-100 bg-gray-50 p-4 space-y-2">
                            <p class="font-semibold text-gray-900">{{ $productoNombre }}</p>
                            <p class="text-xs text-gray-500">
                                Fecha:
                                <span class="font-medium">
                                    {{ optional($review->review_date)->format('d/m/Y') }}
                                </span>
                            </p>

                            <div class="flex items-center gap-1 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star 
                                        {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>

                            <p class="text-xs text-gray-600">
                                {{ $review->comment ?? 'Sin comentario' }}
                            </p>

                            <span class="inline-block px-2 py-1 text-xs rounded-full {{ $badgeClass }}">
                                {{ $statusText }}
                            </span>
                        </div>
                    @endforeach

                    <div class="mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            @else
                <p class="mt-4 text-sm text-gray-500">
                    Aún no has enviado reseñas. ¡Sé el primero en compartir tu opinión!
                </p>
            @endif

        </section>

    </div>
</div>
@endsection
