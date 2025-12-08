import './bootstrap';

import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

document.addEventListener("DOMContentLoaded", () => {
    // ---------- CARRUSEL INFINITO "Productos nuevos" ----------
    const container = document.getElementById("carouselProducts");
    const btnRight  = document.getElementById("btnRight");
    const btnLeft   = document.getElementById("btnLeft");

    const SLIDE_DURATION = 180; // Duración de la animación

    if (container && btnRight && btnLeft) {
        let isAnimating = false;
        let STEP = 0; // ancho de card + gap

        // Calcula el tamaño de un slide
        const calculateStep = () => {
            const firstCard = container.querySelector("article");
            if (!firstCard) return;

            const rect = firstCard.getBoundingClientRect();
            const styles = window.getComputedStyle(firstCard);
            const marginRight = parseFloat(styles.marginRight) || 0;

            STEP = rect.width + marginRight;
        };

        // Se calcula al cargar
        calculateStep();
        // Y se recalcula si cambia el tamaño de pantalla
        window.addEventListener("resize", calculateStep);

        const moveNext = () => {
            if (isAnimating) return;
            const step = STEP;
            if (!step) return;

            isAnimating = true;
            const first = container.querySelector("article");

            container.style.transition = `transform ${SLIDE_DURATION}ms ease-out`;
            container.style.transform  = `translateX(-${step}px)`;

            const onEnd = () => {
                container.style.transition = "none";
                container.style.transform  = "translateX(0)";
                if (first) container.appendChild(first); // pasa la primera al final
                isAnimating = false;
            };

            container.addEventListener("transitionend", onEnd, { once: true });
        };

        const movePrev = () => {
            if (isAnimating) return;
            const step = STEP;
            if (!step) return;

            isAnimating = true;
            const last = container.querySelector("article:last-child");
            if (last) container.insertBefore(last, container.firstChild); // pasa la última al inicio

            // Colocamos desplazado a la izquierda y animamos de regreso
            container.style.transition = "none";
            container.style.transform  = `translateX(-${step}px)`;

            requestAnimationFrame(() => {
                container.style.transition = `transform ${SLIDE_DURATION}ms ease-out`;
                container.style.transform  = "translateX(0)";

                const onEnd = () => {
                    container.style.transition = "none";
                    isAnimating = false;
                };

                container.addEventListener("transitionend", onEnd, { once: true });
            });
        };

        btnRight.addEventListener("click", (e) => {
            e.preventDefault();
            moveNext();   // 1-2-3-4-5-1-2-3-4-5...
        });

        btnLeft.addEventListener("click", (e) => {
            e.preventDefault();
            movePrev();   // 1-5-4-3-2-1-5-4-3-2...
        });
    }

    // --- Gráficos del Panel de Administración ---

    const salesChartCanvas = document.getElementById('salesChart');
    if (salesChartCanvas) {
        const ctx = salesChartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['16 Oct', '19 Oct', '22 Oct', '25 Oct', '28 Oct', '31 Oct', '03 Nov', '06 Nov', '09 Nov', '12 Nov', '15 Nov'],
                datasets: [{
                    label: 'Ventas',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 1400, 1200],
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1600
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    const visitorsChartCanvas = document.getElementById('visitorsChart');
    if (visitorsChartCanvas) {
        const ctx = visitorsChartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['16 Oct', '19 Oct', '22 Oct', '25 Oct', '28 Oct', '31 Oct', '03 Nov', '06 Nov', '09 Nov', '12 Nov', '15 Nov'],
                datasets: [{
                    label: 'Visitantes',
                    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(236, 239, 241, 0.5)',
                    borderColor: 'rgba(117, 117, 117, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 1.0
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});


//codigo para funcionamiento del modal y para agregar productos al carrito 
import Alpine from "alpinejs";

window.Alpine = Alpine;

// GLOBAL: REGISTRA EL STORE DEL CARRITO
document.addEventListener("alpine:init", () => {
    Alpine.data("cartGlobal", cartGlobal);
});

Alpine.start();

//funcion para la logica del carrito
// 
function cartGlobal() {
    return { //carga el carrito desde el navegador
        cartItems: JSON.parse(localStorage.getItem("cartItems")) || [],

        get totalItems() { //contador automatico de productos
            return this.cartItems.reduce((sum, item) => sum + item.qty, 0);
        },

        get totalAmount() { //total en dinero suma automatica
            return this.cartItems.reduce(
                (sum, item) => sum + item.qty * item.price,
                0
            );
        },

        addToCart(product) {  //funcion para agregar productos atravez de un bucle
            let exists = this.cartItems.find((p) => p.id === product.id);

            if (exists) {
                exists.qty++;
            } else {
                this.cartItems.push({ ...product, qty: 1 }); // CORREGIDO
            }

            //guarda el carrito en el navegador
            this.save();

            // abre el modal del carrito
            window.dispatchEvent(new CustomEvent("open-cart"));
        },

        //guarda el carrito en local storage 
        save() {
            localStorage.setItem("cartItems", JSON.stringify(this.cartItems));
        }
    };
}
