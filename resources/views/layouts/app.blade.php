<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50 dark:bg-gray-900">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e5291bc371.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoMmRtgzCSMFTzwVrdnC3sOF0KwsIzRYHBNfZT0="
          crossorigin=""/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles') {{-- Para estilos adicionales por página --}}

    <style>
        body { font-family: 'Poppins', sans-serif; }
        #map { height: 550px; width: 100%; } /* ID del contenedor del mapa */
        .layer-control {
            position: absolute; top: 10px; right: 10px; z-index: 1000; /* Asegura que esté por encima del mapa */
            background: white; padding: 8px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        /* Estilos para el modo oscuro, si lo habilitaste con Breeze */
        .dark .bg-gray-50 { background-color: #1f2937; } /* bg-gray-800 */
        .dark .text-gray-800 { color: #e5e7eb; } /* text-gray-200 */
        .dark .bg-white { background-color: #111827; } /* bg-gray-900 */
        .dark .shadow-sm { box-shadow: none; }
        .dark .text-gray-600 { color: #9ca3af; } /* text-gray-400 */
        .dark .border-gray-100 { border-color: #374151; } /* border-gray-700 */
        .dark .text-gray-700 { color: #d1d5db; } /* text-gray-300 */
        .dark .border-gray-300 { border-color: #4b5563; } /* border-gray-600 */
        .dark .text-gray-500 { color: #9ca3af; }
    </style>
</head>
<body class="flex flex-col min-h-screen text-gray-800 dark:bg-gray-900 dark:text-gray-200 antialiased">
    <div class="main-container">
        <header class="bg-white dark:bg-gray-900 px-6 py-3 flex justify-between items-center shadow-sm dark:shadow-none border-b dark:border-gray-700">
            <img src="{{ asset('images/image.png') }}" alt="Logo" class="h-12 w-auto">
            <nav class="space-x-4">
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-cyan-700 dark:hover:text-cyan-400 transition">Mapa</a>
                <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-cyan-700 dark:hover:text-cyan-400 transition">Glosario</a>
            </nav>
        </header>

        <div class="bg-gradient-to-r from-[#02697e] to-[#3e98a6] px-8 py-4 shadow-md">
            <h1 class="text-white font-bold text-lg tracking-wide">
                Sistema de Monitoreo de Aguas Valle Pupío
            </h1>
        </div>

        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                {{-- Sidebar --}}
                <aside class="md:col-span-3">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 border dark:border-gray-700">
                        <h5 class="font-bold text-gray-700 dark:text-gray-300 mb-2 flex items-center">
                            <i class="fas fa-search mr-2"></i> Explorar
                        </h5>
                        <hr class="border-gray-300 dark:border-gray-600 mb-4">
                        <div id="side" class="min-h-[200px] text-gray-700 dark:text-gray-300">
                            @yield('sidebar-content') {{-- Contenido dinámico del sidebar --}}
                        </div>
                    </div>
                </aside>

                {{-- Contenido principal --}}
                <section class="md:col-span-9">
                    @yield('content') {{-- Aquí se inyectará el contenido de cada vista --}}
                </section>
            </div>
        </main>

        <footer class="bg-[#2d2d2d] text-white py-10 dark:bg-gray-900 border-t dark:border-gray-700">
            <div class="container mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-center text-center md:text-left">
                    <div class="flex justify-center md:justify-start">
                        <img src="{{ asset('images/antofagasta-mineralsWT.png') }}" class="max-h-16" alt="AM">
                    </div>

                    <div class="text-xs space-y-2 text-gray-300">
                        <p><span class="font-bold"><i class="fas fa-mobile-alt mr-2"></i>Teléfono:</span> +56 2 3456 7890</p>
                        <p><span class="font-bold"><i class="fas fa-envelope mr-2"></i>Email:</span> comunicacionesexternas@pelambres.cl</p>
                        <p><span class="font-bold"><i class="fas fa-globe mr-2"></i>Web:</span> www.aminerals.com</p>
                    </div>

                    <div class="text-xs text-gray-400 leading-relaxed">
                        Este desarrollo ha sido implementado por <span class="font-bold text-white">GP Consultores</span>, a través de su equipo especializado en soluciones de monitoreo web.
                        <br>gp@gpconsultores.cl
                    </div>

                    <div class="flex justify-center md:justify-end">
                        <img src="{{ asset('images/gp-blanco.png') }}" class="max-h-14" alt="GP">
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20n6sQz78C9aY6K4jWv9aW9+E9e8mN5w9z+sD4iN5z4="
            crossorigin=""></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    @stack('scripts') {{-- Para scripts adicionales por página --}}

</body>
</html>