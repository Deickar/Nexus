@extends('layouts.app')

@section('content')
<div class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        {{--
        |--------------------------------------------------------------------------
        | Encabezado de la Página
        |--------------------------------------------------------------------------
        |
        | Saludo personalizado para el administrador.
        |
        --}}
        <div class="mb-8 bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-4xl font-bold text-gray-800">¡Bienvenido, Administrador!</h1>
            <p class="text-gray-600 mt-2">Aquí tienes un resumen de la actividad de tu tienda.</p>
        </div>

    {{--
    |--------------------------------------------------------------------------
    | Sección 1: Detalles Generales
    |--------------------------------------------------------------------------
    |
    | Muestra una serie de tarjetas con métricas clave del negocio, como
    | ventas totales, número de órdenes, clientes, promedio de ventas y
    | facturas pendientes.
    |
    --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Detalles generales</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <!-- Card: Ventas totales -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center transition-transform transform hover:scale-105 hover:shadow-xl">
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 10v-1m0-6c-1.657 0-3 .895-3 2s1.343 2 3 2m0-4a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Ventas totales</p>
                    <p class="text-2xl font-bold">Q{{ number_format($dashboardData['total_sales'] ?? 0, 2) }}</p>
                    <p class="text-green-500 text-xs">↑ 1760.33%</p>
                </div>
            </div>
            <!-- Card: Órdenes totales -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center transition-transform transform hover:scale-105 hover:shadow-xl">
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Órdenes totales</p>
                    <p class="text-2xl font-bold">{{ $dashboardData['total_orders'] ?? 0 }}</p>
                    <p class="text-green-500 text-xs">↑ 180%</p>
                </div>
            </div>
            <!-- Card: Clientes totales -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center transition-transform transform hover:scale-105 hover:shadow-xl">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Clientes totales</p>
                    <p class="text-2xl font-bold">{{ $dashboardData['total_clients'] ?? 0 }}</p>
                    <p class="text-green-500 text-xs">↑ 100%</p>
                </div>
            </div>
            <!-- Card: Promedio de ventas -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center transition-transform transform hover:scale-105 hover:shadow-xl">
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Promedio de ventas</p>
                    <p class="text-2xl font-bold">Q199.49</p>
                    <p class="text-green-500 text-xs">↑ 564.40%</p>
                </div>
            </div>
            <!-- Card: Total de facturas no pagadas -->
            <div class="bg-white p-6 rounded-lg shadow-md flex items-center transition-transform transform hover:scale-105 hover:shadow-xl">
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-gray-600 text-sm">Total de facturas no pagadas</p>
                    <p class="text-2xl font-bold">Q0.00</p>
                </div>
            </div>
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | Sección 2: Detalles de Hoy y Umbral de Existencias
    |--------------------------------------------------------------------------
    |
    | Esta sección se divide en dos partes:
    | 1. Un resumen de las métricas del día actual (ventas, pedidos, clientes).
    | 2. Una lista de productos que están bajos en stock, para un rápido
    |    control de inventario.
    |
    --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Detalles de hoy</h2>
        <div class="bg-white p-6 rounded-lg shadow-md mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Ventas totales de hoy -->
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 10v-1m0-6c-1.657 0-3 .895-3 2s1.343 2 3 2m0-4a2 2 0 100-4 2 2 0 000 4z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Ventas totales</p>
                        <p class="text-xl font-bold">Q{{ number_format($dashboardData['today_sales'] ?? 0, 2) }}</p>
                        <p class="text-green-500 text-xs">↑ 1760.33%</p>
                    </div>
                </div>
                <!-- Pedidos de hoy -->
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Pedidos hoy</p>
                        <p class="text-xl font-bold">{{ $dashboardData['today_orders'] ?? 0 }}</p>
                        <p class="text-green-500 text-xs">↑ 180%</p>
                    </div>
                </div>
                <!-- Clientes de hoy -->
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 016-6h6a6 6 0 016 6v1h-3"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-600 text-sm">Clientes de hoy</p>
                        <p class="text-xl font-bold">{{ $dashboardData['today_clients'] ?? 0 }}</p>
                        <p class="text-red-500 text-xs">↓ 100%</p>
                    </div>
                </div>
            </div>
            {{--
            |------------------------------------------------------------------
            | Tarjeta de Transacción Reciente
            |------------------------------------------------------------------
            |
            | Muestra los detalles de la última transacción, incluyendo el
            | número de orden, fecha, estado, método de pago, cliente y
            | las imágenes de los productos comprados.
            |
            --}}
            @if(isset($dashboardData['recent_transaction']))
                @php $transaction = (object)$dashboardData['recent_transaction']; @endphp
                <div class="border-t pt-4 mt-4 flex items-start justify-between">
                    <div class="flex flex-wrap items-center gap-x-8 gap-y-4">
                        {{-- Columna 1: Detalles de la Orden --}}
                        <div class="flex-shrink-0">
                            <p class="font-bold text-gray-800">#{{ $transaction->id ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">{{ \Carbon\Carbon::parse($transaction->date ?? now())->format('d M Y, H:i:s') }}</p>
                            <span class="inline-block mt-1 px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">{{ $transaction->status ?? 'Completado' }}</span>
                        </div>

                        {{-- Columna 2: Método de Pago --}}
                        <div class="flex-shrink-0">
                            <p class="font-semibold text-gray-700">{{ $transaction->payment_method ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">Predeterminado</p>
                        </div>

                        {{-- Columna 3: Detalles del Cliente --}}
                        <div class="flex-shrink-0">
                            <p class="font-bold text-gray-800">{{ $transaction->client['name'] ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction->client['email'] ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">{{ $transaction->client['city'] ?? 'N/A' }}</p>
                        </div>

                        {{-- Columna 4: Imágenes de Productos --}}
                        <div class="flex items-center space-x-2">
                            @foreach($transaction->products as $product)
                                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-10 h-10 bg-gray-200 rounded-md shadow-sm object-cover">
                            @endforeach
                        </div>
                    </div>

                    {{-- Icono de flecha a la derecha --}}
                    <div class="self-center">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            @else
                <div class="text-center py-4 mt-4 border-t">
                    <p class="text-gray-500">No hay transacciones recientes.</p>
                </div>
            @endif
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Umbral de existencias</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            {{--
            |------------------------------------------------------------------
            | Bucle de Productos
            |------------------------------------------------------------------
            |
            | Itera sobre la colección de productos (`$products`) que se pasa
            | desde el controlador. Cada producto se muestra en una fila
            | con su imagen, nombre, descripción, precio y stock.
            | El `loop->last` se usa para no añadir un borde inferior al
            | último elemento, manteniendo el diseño limpio.
            |
            --}}
            @foreach ($products as $product)
            <div class="{{ !$loop->last ? 'border-b' : '' }}">
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center">
                        {{-- Imagen del producto --}}
                        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-16 h-16 object-cover rounded-md">
                        <div class="ml-4">
                            {{-- Nombre y descripción --}}
                            <p class="font-bold text-gray-800">{{ $product['name'] }}</p>
                            <p class="text-gray-600 text-sm truncate w-64">{{ $product['description'] }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="text-right mr-6">
                            {{-- Precio y stock --}}
                            <p class="font-bold text-gray-800">Q{{ number_format($product['price'], 2) }}</p>
                            {{--
                            | Lógica condicional para el color del stock:
                            | - Rojo si el stock es 5 o menos.
                            | - Amarillo si está entre 6 y 20.
                            | - Verde si es mayor a 20.
                            --}}
                            <p class="text-sm
                                @if($product['stock'] <= 5) text-red-500
                                @elseif($product['stock'] <= 20) text-yellow-500
                                @else text-green-500
                                @endif
                            ">
                                {{ $product['stock'] }} stock
                            </p>
                        </div>
                        {{-- Icono de flecha --}}
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | Sección 3: Estadísticas y Productos Más Vendidos
    |--------------------------------------------------------------------------
    |
    | Contiene dos gráficos para visualizar las tendencias de ventas y visitas.
    | Debajo, se muestra una galería con los productos más populares para
    | identificar rápidamente los artículos de mayor éxito.
    |
    --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Estadísticas</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Gráfico de Ventas -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-lg mb-2">Total Sales</h3>
                <p class="text-gray-600 text-sm">16 Oct - 15 Nov</p>
                <div class="mt-4">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
            <!-- Gráfico de Visitantes -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-bold text-lg mb-2">Visitors</h3>
                <p class="text-gray-600 text-sm">16 Oct - 15 Nov</p>
                <div class="mt-4">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Productos más vendidos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{--
            |------------------------------------------------------------------
            | Bucle de Productos Más Vendidos
            |------------------------------------------------------------------
            |
            | Similar a la sección anterior, este bucle itera sobre los
            | productos para mostrar las tarjetas de los más vendidos.
            | Cada tarjeta incluye la imagen, nombre y descripción del
            | producto.
            |
            --}}
            @foreach ($products as $product)
            <div class="bg-white p-4 rounded-lg shadow-md">
                {{-- Imagen del producto --}}
                <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }}" class="w-full h-40 object-cover rounded-md mb-4">
                {{-- Nombre y descripción --}}
                <h3 class="font-bold text-gray-800">{{ $product['name'] }}</h3>
                <p class="text-gray-600 text-sm">{{ $product['description'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | Sección 4: Cliente con Mayor Volumen de Ventas
    |--------------------------------------------------------------------------
    |
    | Presenta una lista de los clientes más valiosos, mostrando su nombre,
    | correo electrónico, el total de sus compras y el número de órdenes
    | realizadas en un período determinado.
    |
    --}}
    <div>
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Cliente con mayor volumen de ventas</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Cabecera -->
            <div class="flex justify-between items-center pb-2 border-b">
                <p class="text-gray-600 text-sm">Cliente</p>
                <p class="text-gray-600 text-sm">16 oct - 14 nov</p>
            </div>
            @if(isset($dashboardData['top_clients']) && count($dashboardData['top_clients']) > 0)
                @foreach ($dashboardData['top_clients'] as $client)
                <div class="flex justify-between items-center py-4 {{ !$loop->last ? 'border-b' : '' }}">
                    <div>
                        <p class="font-bold">{{ $client['name'] }}</p>
                        <p class="text-gray-600 text-sm">{{ $client['email'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">Q{{ number_format($client['total_spent'], 2) }}</p>
                        <p class="text-gray-600 text-sm">{{ $client['orders_count'] }} ordenes</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <p class="text-gray-500">No hay datos de clientes disponibles.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
