ESTRUCTURA DE NEXUS ECOMMERCE

Nexus_Ecommerce/
│
├── app/
│ └── Http/
│ └── Controllers/
│ ├── Controller.php # Controlador base de Laravel
│ ├── HomeController.php # Página principal, categorías, carrito, etc.
│ ├── AccountController.php # Módulo "Mi cuenta": perfil, dirección, órdenes, reseñas, favoritos
│ └── AdminController.php # Panel de administración (dashboard, perfil admin)
│
├── bootstrap/ # Arranque del framework
│
├── public/
│ ├── build/ # Archivos generados por Vite (CSS/JS compilados)
│ ├── img/ # Imágenes públicas (logo, productos, clientes, etc.)
│ └── index.php # Punto de entrada HTTP
│
├── resources/
│ ├── css/
│ │ └── app.css # Tailwind + estilos personalizados Nexus
│ │
│ ├── js/
│ │ └── app.js # Carrusel infinito, Alpine.js, gráficos del admin
│ │
│ └── views/
│ ├── layouts/
│ │ └── app.blade.php # Layout principal (navbar, buscador, iconos, footer)
│ │
│ ├── home.blade.php # Portada Nexus (hero, productos nuevos, beneficios, reseñas)
│ ├── contact.blade.php # Página de contacto
│ ├── categories.blade.php # Vista general de categorías
│ ├── category-page.blade.php # Productos dentro de una categoría específica
│ ├── offers.blade.php # Ofertas del día
│ ├── carrito.blade.php # Vista del carrito de compras
│ │
│ ├── login/ # Módulo de autenticación
│ │ ├── login.blade.php # Inicio de sesión Nexus
│ │ ├── register.blade.php # Registro de usuario
│ │ ├── password.blade.php # Formulario "Olvidé mi contraseña"
│ │ └── reset-password.blade.php # Formulario para cambiar contraseña
│ │
│ ├── account/ # Área "Mi cuenta" del usuario
│ │ ├── profile.blade.php # Perfil: datos personales (nombre, fecha, teléfono, etc.)
│ │ ├── address.blade.php # Direcciones de envío
│ │ ├── orders.blade.php # Historial de órdenes (tabla + versión móvil)
│ │ ├── reviews.blade.php # Reseñas hechas por el usuario
│ │ └── favorites.blade.php # Productos marcados como favoritos
│ │
│ └── admin/ # Panel de administración
│ ├── index.blade.php # Dashboard/resumen del admin (gráficas, tarjetas)
│ └── profile.blade.php # Perfil del administrador
│
├── routes/
│ └── web.php # Rutas HTTP principales (home, login, cuenta, admin, etc.)
│  
│
├── storage/ # Logs, caché, archivos generados
│
├── .env # Configuración del entorno (DB, mail, etc.)
├── artisan # Ejecutable de comandos Laravel
├── composer.json # Dependencias PHP (Laravel, etc.)
├── package.json # Dependencias frontend (Vite, Tailwind, Alpine, Chart.js…)
├── vite.config.js # Configuración de Vite para compilar assets
└── README.md # Documentación del proyecto
