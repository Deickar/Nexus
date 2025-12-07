<!-- Componente principal del carrito controlado con Alpine.js -->
<div x-data="cart()"  
     x-init="loadCart()"  
     @toggle-cart.window="open = !open" 
     @add-to-cart.window="add($event.detail)" 
     x-cloak> <!-- Oculta el contenido hasta que Alpine se cargue -->

    <!-- Modal (deslizable desde la derecha) -->
    <div x-show="open"
         class="fixed inset-0 z-50 flex"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full">

        <!-- Fondo oscuro -->
        <div class="flex-1 bg-black/40" @click="open = false"></div>

        <!-- Panel principal -->
        <div class="w-full max-w-sm bg-white flex flex-col shadow-xl">

            <!-- Encabezado del carrito -->
            <div class="bg-white text-blue-700 p-4 pt-14 flex justify-between items-center">
                <h2 class="text-xl font-bold">
                    Carrito de compras (<span x-text="totalItems"></span>)
                </h2>

                <button @click="open = false" class="text-3xl leading-none">&times;</button>
            </div>

            <!-- Mensaje promocional -->
            <div class="bg-white text-gray-700 flex justify-center items-center">
                <h1 class="text-xs font-bold text-center px-4">
                    Consigue hasta un 30% de descuento en tu primer pedido!
                </h1>
            </div>

            <!-- Lista de productos -->
            <div class="flex-1 p-4 overflow-y-auto">

                <!-- Si no hay productos -->
                <template x-if="totalItems === 0">
                    <p class="text-center text-gray-900 py-10 text-lg">Tu carrito está vacío</p>
                </template>

                <!-- Productos -->
                <template x-for="item in cartItems" :key="item.id">
                    <div class="flex justify-between items-center border-b py-3">

                        <!-- Info del producto -->
                        <div>
                            <h3 class="font-bold" x-text="item.name"></h3>
                            <p class="text-gray-500">
                                Cant: <span x-text="item.qty"></span> × 
                                Q<span x-text="item.price"></span>
                            </p>
                        </div>

                        <!-- Controles -->
                        <div class="text-right">
                            <p class="font-bold text-lg">
                                Q<span x-text="(item.qty * item.price).toFixed(2)"></span>
                            </p>

                            <div class="flex gap-2 mt-2">
                                <button @click="updateQty(item.id, 'minus')" class="px-2 py-1 bg-gray-200 rounded">-</button>

                                <button @click="updateQty(item.id, 'plus')"  class="px-2 py-1 bg-gray-200 rounded">+</button>

                                <button @click="remove(item.id)" class="text-red-600">Eliminar</button>
                            </div>
                        </div>

                    </div>
                </template>

            </div>

            <!-- Footer del carrito -->
            <div x-show="totalItems > 0" class="p-4 bg-gray-100 border-t">
                <p class="text-right text-xl font-bold text-blue-700">
                    Total: Q<span x-text="totalAmount.toFixed(2)"></span>
                </p>

                <button class="mt-4 bg-green-600 text-white py-3 rounded-lg w-full">
                    Ir a pagar
                </button>
            </div>

        </div>

    </div>
</div>

<script>
/* 
    FUNCIÓN PRINCIPAL DEL CARRITO (ALPINE.JS)
    Maneja:
    - Agregar productos
    - Aumentar/disminuir cantidades
    - Eliminar productos
    - Guardar en localStorage
    - Calcular totales
*/
function cart() {
    return {
        open: false,        // Controla si el carrito está visible
        cartItems: [],      // Lista de productos
        totalItems: 0,      // Cantidad total
        totalAmount: 0,     // Total en dinero

        // Cargar carrito desde localStorage
        loadCart() {
            this.cartItems = JSON.parse(localStorage.getItem('cart') || '[]');
            this.calculate();
        },

        // Guardar carrito
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cartItems));
        },

        // Calcular totales
        calculate() {
            this.totalItems  = this.cartItems.reduce((n, i) => n + i.qty, 0);
            this.totalAmount = this.cartItems.reduce((n, i) => n + i.qty * i.price, 0);
            this.saveCart();
        },

        // Agregar producto
        add(product) {
            let item = this.cartItems.find(i => i.id === product.id);
            if (item) item.qty++;
            else this.cartItems.push({ ...product, qty: 1 });

            this.open = true;
            this.calculate();
        },

        // Actualizar cantidad
        updateQty(id, action) {
            let item = this.cartItems.find(i => i.id === id);
            if (!item) return;

            if (action === 'plus') item.qty++;
            if (action === 'minus') item.qty--;

            if (item.qty <= 0) this.remove(id);

            this.calculate();
        },

        // Eliminar producto
        remove(id) {
            this.cartItems = this.cartItems.filter(i => i.id !== id);
            this.calculate();
        }
    }
}
</script>
