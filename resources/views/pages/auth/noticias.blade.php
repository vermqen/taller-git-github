<x-layouts::app :title="__('Centro de Noticias')">
    <div class="w-full space-y-8 p-6 lg:p-10">

        <!-- ENCABEZADO DE SECCIÓN -->
        <header class="rounded-2xl bg-zinc-900/95 p-8 border border-zinc-800/80 text-white shadow-xl backdrop-blur-md">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-400">
                        {{ $team->name ?? 'EQUIPO' }} // TRANSMISIÓN EN VIVO
                    </p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight sm:text-4xl">Centro de noticias</h1>
                    <p class="mt-2 text-sm text-zinc-400 max-w-2xl">
                        Todo lo que pasa en tus juegos, filtrado y clasificado para tu comunidad.
                    </p>
                </div>

                @if(Route::has('noticias.create'))
                    <a href="{{ route('noticias.create', $team->slug ?? 'default') }}" wire:navigate
                       class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-zinc-950 transition hover:bg-amber-300">
                        Publicar noticia
                    </a>
                @endif
            </div>
        </header>

        <!-- GRID DE NOTICIAS (RESPONSIVO Y FLUIDO) -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                [
                    'img' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80',
                    'badge' => 'ÚLTIMAS NOTICIAS', 'read' => '4 MIN READ',
                    'title' => 'PROYECTO BLACKOUT: Descifrando las nuevas reglas de extracción',
                    'desc'  => 'Un análisis exhaustivo de las mecánicas del parche v4.12, las nubes de radiación dinámicas y las rutas tácticas.',
                    'user'  => 'GhostOperator', 'time' => 'HACE 2H'
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=800&q=80',
                    'badge' => 'ÚLTIMOS PARCHES', 'read' => '6 MIN READ',
                    'title' => 'NEON VELOCITY: Actualización de motor de aceleración',
                    'desc'  => 'Revisión completa de la física de derrape en circuitos urbanos y enlaces cibernéticos nivel 3.',
                    'user'  => 'ViperNet', 'time' => 'HACE 5H'
                ],
                [
                    'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2egqTlMnCfV58BI3PDDycOGJIcO2o2zqKVBgSoK1Piaz6jTbnvYUgjBA&s=10',
                    'badge' => 'ANÁLISIS DE JUEGO', 'read' => '5 MIN READ',
                    'title' => 'SHADOW REALMS: Estrategias de sigilo y combate',
                    'desc'  => 'Exploración de las mecánicas de sigilo, rutas de escape y optimización de recursos en entornos urbanos.',
                    'user'  => 'StealthMaster', 'time' => 'HACE 3H'
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?auto=format&fit=crop&w=800&q=80',
                    'badge' => 'NOVEDADES', 'read' => '7 MIN READ',
                    'title' => 'CYBER HORIZON: Explorando la expansión de mundo abierto',
                    'desc'  => 'Análisis de la nueva expansión, incluyendo misiones secundarias y la integración de la inteligencia artificial.',
                    'user'  => 'CyberExplorer', 'time' => 'HACE 4H'
                ],
                [
                    'img' => 'https://images.unsplash.com/photo-1593642634367-d91a135587b5?auto=format&fit=crop&w=800&q=80',
                    'badge' => 'MOTOR GRÁFICO', 'read' => '8 MIN READ',
                    'title' => 'VIRTUAL REALITY: Mejoras en la física y la interacción',
                    'desc'  => 'Revisión de las últimas mejoras en el motor de realidad virtual, incluyendo simulación de físicas y respuesta háptica.',
                    'user'  => 'VRTechie', 'time' => 'HACE 6H'
                ],
            ] as $game)
                
                <!-- TARJETA INDIVIDUAL DE NOTICIA -->
                <article class="group flex flex-col overflow-hidden rounded-2xl border border-zinc-800 bg-zinc-900 transition-all duration-300 hover:border-amber-400/50 hover:shadow-lg hover:shadow-amber-400/5">
                    
                    <!-- IMAGEN DE LA NOTICIA CON EFECTO ZOOM -->
                    <div class="relative h-48 w-full overflow-hidden bg-zinc-950">
                        <img src="{{ $game['img'] }}" 
                             alt="{{ $game['title'] }}" 
                             class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-transparent opacity-60"></div>
                        
                        <!-- ETIQUETA / BADGE -->
                        <span class="absolute top-3 left-3 rounded-lg bg-zinc-950/80 px-2.5 py-1 text-[10px] font-bold tracking-wider text-amber-400 backdrop-blur-md">
                            {{ $game['badge'] }}
                        </span>
                    </div>

                    <!-- CONTENIDO DE LA TARJETA -->
                    <div class="flex flex-1 flex-col justify-between p-6">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-xs text-zinc-500">
                                <span>{{ $game['read'] }}</span>
                                <span class="font-mono text-zinc-400">{{ $game['time'] }}</span>
                            </div>

                            <h2 class="text-lg font-bold text-zinc-100 group-hover:text-amber-400 transition-colors line-clamp-2">
                                {{ $game['title'] }}
                            </h2>

                            <p class="text-sm text-zinc-400 line-clamp-3">
                                {{ $game['desc'] }}
                            </p>
                        </div>

                        <!-- AUTOR / PIE DE TARJETA -->
                        <div class="mt-6 flex items-center justify-between border-t border-zinc-800/80 pt-4 text-xs">
                            <span class="font-medium text-zinc-300">Por <strong class="text-amber-400">{{ $game['user'] }}</strong></span>
                            <span class="font-semibold text-zinc-400 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                Leer más &rarr;
                            </span>
                        </div>
                    </div>
                </article>

            @endforeach
        </div>

    </div>
</x-layouts::app>