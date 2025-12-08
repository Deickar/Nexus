**Documento comentado: `resources/views/offers.blade.php`**

Breve descripción:
- **Propósito:** Vista Blade que muestra una sección de "Ofertas del Día" con una cuadrícula de tarjetas de producto. Diseñada con clases Tailwind CSS y plantillas Blade.
- **Ubicación original:** `resources/views/offers.blade.php`

**Resumen rápido de la estructura**
- Extiende la plantilla base `layouts.app`.
- Define la sección `content` de Blade donde va todo el HTML de la página.
- Contiene un `<section>` principal con un encabezado, una descripción y una grid responsive (`grid-cols-1 sm:grid-cols-2 md:grid-cols-4`).
- Dentro de la grid hay 6 tarjetas de producto repetidas manualmente (imagen, etiqueta de oferta, título, precio con/ sin descuento).
- Al final hay un CTA (botón "Comprar ahora").

**Archivo original (sin alterar)**
```php
@extends('layouts.app')

@section('content')

<section class="bg-[#f4f6fb] py-16">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl md:text-5xl font-extrabold text-center text-[#2128A6] mb-4">
            🎈Ofertas del Día🎉
        </h1>

        <p class="text-center text-gray-600 mb-12">
            Aprovecha las promociones exclusivas disponibles por tiempo limitado.
        </p>

        {{-- GRID --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">

            {{-- TARJETA 1 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/audifonos.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -20%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Audífonos inalámbricos</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q499</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q399</span>
                </div>
            </div>

            {{-- TARJETA 2 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/lenovolaptop.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#30D9C8] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        Nuevo precio
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Laptop Lenovo 14"</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q5,999</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q4,999</span>
                </div>
            </div>

            {{-- TARJETA 3 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/perfumehugoboss.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        2x1
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Perfume edición especial</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-[#30D9C8] font-bold text-lg">Q299</span>
                </div>
            </div>

            {{-- TARJETA 4 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/zapatozara.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -10%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Zapatillas urbanas</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q799</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q719</span>
                </div>
            </div>

            {{-- TARJETA 5 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/tabk10.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -5%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Tablet Xiaomi</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q335</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q319</span>
                </div>
            </div>

            {{-- TARJETA 6 --}}
            <div class="bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition cursor-pointer">
                <div class="relative h-44 rounded-xl overflow-hidden mb-4">
                    <img src="/img/dulce.jpg" class="w-full h-full object-cover">
                    <span class="absolute top-3 left-3 bg-[#FF5C7A] text-white text-sm font-semibold px-3 py-1 rounded-full">
                        -5%
                    </span>
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Chicle</h3>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-gray-400 line-through text-sm">Q2</span>
                    <span class="text-[#30D9C8] font-bold text-lg">Q1</span>
                </div>
            </div>

        </div> {{-- fin grid --}}

        <div class="text-center mt-12">
            <p class="text-gray-700 mb-4">¡No te quedes sin aprovechar estas promociones!</p>

            <a href="#" class="inline-block bg-gradient-to-r from-[#30D9C8] to-[#77D9CF] text-white px-8 py-3 rounded-full text-lg font-semibold shadow-md hover:scale-[1.03] transition">
                Comprar ahora
            </a>
        </div>

    </div>
</section>

@endsection
```

**Comentarios por secciones (explicación y recomendaciones)**

- **@extends('layouts.app')**:
  - Indica que esta vista hereda de la plantilla `layouts.app`. Ahí se espera que haya la estructura base (head, scripts, nav, footer).
  - Recomendación: verificar que la plantilla base incluya las meta tags y los CSS/JS necesarios (Tailwind, Vite, etc.).

- **@section('content') ... @endsection**:
  - Define la sección `content` que se inyecta en la plantilla base.
  - Mantén sólo el contenido específico de la página aquí.

- **<section class="bg-[#f4f6fb] py-16">**:
  - Contenedor principal con fondo claro y padding vertical.
  - Uso de `max-w-7xl mx-auto px-6` para centrar y limitar ancho.

- **Encabezado y descripción**:
  - `<h1>` con clases responsivas y emojis.
  - `<p>` descriptiva de la sección.
  - Recomendación: si te preocupa accesibilidad, el emoji puede necesitar `aria-hidden="true"` y el texto visible conservarse para lectores de pantalla.

- **Grid de tarjetas**:
  - `grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8` hace la grid responsive.
  - Actualmente las tarjetas están codificadas manualmente (duplicación).
  - Recomendación: convertir a un loop (por ejemplo pasar un array de ofertas desde el controlador y usar `@foreach($offers as $offer)`), así reduces duplicación y facilitas mantenimiento.

- **Cada tarjeta**:
  - Estructura común: contenedor blanco, imagen con `object-cover`, etiqueta de oferta en `span` posicionado absolute, título y precios.
  - Clases para hover: `hover:scale-[1.02] transition` añade interacción suave.
  - Precios: usas `line-through` para precio anterior y color distinto para precio actual.
  - Recomendación de accesibilidad: las imágenes deberían incluir `alt="Descripción del producto"`. Ahora no tienen `alt`, eso afecta a SEO y lectores de pantalla.
  - Recomendación de rendimiento: si el sitio escala, usar `loading="lazy"` en `<img>` y servir imágenes optimizadas (webp, tamaños responsivos).

- **Etiquetas de oferta**:
  - Usas colores sólidos con `rounded-full`. Está bien, pero asegúrate de contraste suficiente con el fondo de la etiqueta y la imagen.

- **CTA final**:
  - Botón `Comprar ahora` con gradiente y efecto hover.
  - Recomendación: el `href="#"` es temporal; enlaza a la acción real o añade `role="button"` y control de accesibilidad si es un placeholder.

**Posibles mejoras/Refactor sugerido**
- Pasar datos desde el controlador (o componente Livewire/Vue/Alpine):
  - Ejemplo en controlador: `$offers = Offer::active()->take(20)->get(); return view('offers', compact('offers'));`
  - En Blade usar `@foreach($offers as $offer)` y una pequeña partial `resources/views/components/offer-card.blade.php` para la tarjeta.
- Añadir `alt` a las imágenes y `aria-label`/`aria-hidden` donde corresponda.
- Hacer que la tarjeta sea un link (`<a>` que envuelva la tarjeta) en vez de solo `cursor-pointer` para que sea navegable por teclado.
- Considerar la paginación o carga perezosa (infinite scroll) si habrá muchas ofertas.
- Internacionalización: extraer textos a archivos de idioma si planeas multi-idioma.

**Fragmento sugerido (uso de loop y partial)**
- Partial `resources/views/components/offer-card.blade.php` (ejemplo breve):
```php
<a href="{{ route('product.show', $offer->id) }}" class="group block bg-white rounded-2xl shadow-lg p-5 hover:scale-[1.02] transition">
  <div class="relative h-44 rounded-xl overflow-hidden mb-4">
    <img src="{{ asset($offer->image) }}" alt="{{ $offer->title }}" class="w-full h-full object-cover" loading="lazy">
    @if($offer->badge)
      <span class="absolute top-3 left-3 bg-...">{{ $offer->badge }}</span>
    @endif
  </div>
  <h3 class="text-lg font-semibold text-gray-800">{{ $offer->title }}</h3>
  <div class="flex items-center gap-3 mt-2">
    @if($offer->old_price)
      <span class="text-gray-400 line-through text-sm">{{ money($offer->old_price) }}</span>
    @endif
    <span class="text-[#30D9C8] font-bold text-lg">{{ money($offer->price) }}</span>
  </div>
</a>
```

**Notas finales**
- Este documento explica la intención y sugiere mejoras. Si quieres, puedo:
  - Generar automáticamente la partial `offer-card.blade.php` y refactorizar `offers.blade.php` para usar `@foreach`.
  - Añadir `alt` automáticamente usando una regla (por ejemplo usar el nombre del producto si existe).
  - Implementar pruebas visuales mínimas o una snapshot con Percy/VRT (si corresponde).

Si quieres que haga el refactor (convertir la vista para recibir datos y usar partials), dime y lo implemento.  

---
Documento generado automáticamente el: 1 de diciembre de 2025
