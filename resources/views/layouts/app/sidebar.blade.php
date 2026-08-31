@php
    $teamSlug = $teamSlug ?? (isset($team) ? $team->slug : (auth()->user()?->currentTeam?->slug ?? request()->route('team')));
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-950 font-sans text-zinc-100 antialiased" x-data="{ sidebarOpen: true }">

        <div class="flex min-h-screen w-full">

            <!-- ================================================= -->
            <!-- SIDEBAR PRINCIPAL                                 -->
            <!-- ================================================= -->
            <aside 
                class="sticky top-0 z-40 flex h-screen shrink-0 flex-col border-r border-zinc-800/80 bg-zinc-900/95 backdrop-blur-md transition-all duration-300 ease-in-out"
                x-bind:class="sidebarOpen ? 'w-64 p-4' : 'w-20 items-center p-3'"
            >
                <!-- CABECERA DE NAVEGACIÓN -->
                <div class="flex w-full items-center justify-between">
                    
                    <!-- LOGO VISIBLE SOLO CUANDO EL SIDEBAR ESTÁ ABIERTO -->
                    <div class="overflow-hidden transition-all duration-300" x-show="sidebarOpen" x-transition.opacity>
                        @auth
                            <a href="{{ $teamSlug ? route('dashboard', $teamSlug) : route('home') }}"
                               wire:navigate
                               class="flex items-center"
                               title="Ir al inicio">
                                <img src="{{ asset('nexus.png') }}"
                                     alt="Nexus Logo"
                                     class="h-9 w-auto object-contain"
                                >
                            </a>
                        @endauth
                    </div>

                    <!-- LOGO COMPACTO (ISOTIPO) CUANDO ESTÁ CERRADO -->
                    <div class="flex w-full justify-center overflow-hidden" x-show="!sidebarOpen" x-transition.opacity>
                        @auth
                            <a href="{{ $teamSlug ? route('dashboard', $teamSlug) : route('home') }}"
                               wire:navigate
                               title="Ir al inicio">
                                <!-- Asegúrate de tener una versión cuadrada o usa el mismo archivo con ancho controlado -->
                                <img src="{{ asset('nexus.png') }}"
                                     alt="Nexus Icon"
                                     class="h-8 w-8 object-contain"
                                >
                            </a>
                        @endauth
                    </div>

                    <!-- BOTÓN HAMBURGUESA / TOGGLE (Siempre accesible y fijo en su contenedor) -->
                    <button 
                        @click="sidebarOpen = !sidebarOpen" 
                        class="flex shrink-0 items-center justify-center rounded-lg p-2 text-zinc-400 transition-colors hover:bg-zinc-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-amber-400/50"
                        :aria-expanded="sidebarOpen.toString()"
                        aria-label="Alternar menú de navegación"
                    >
                        <flux:icon.bars-3 class="size-6 shrink-0 text-amber-400" />
                    </button>
                </div>

                <!-- SELECTOR DE EQUIPOS (CONTEXT SWITCHER) -->
                @auth
                    <div x-show="sidebarOpen" x-transition.opacity class="mt-4 w-full">
                        <livewire:team-switcher />
                    </div>
                @endauth

                <!-- NAVEGACIÓN DE PLATAFORMA -->
                <nav x-show="sidebarOpen" x-transition.duration.200ms class="mt-2 flex w-full flex-1 flex-col justify-between overflow-hidden">
                    <flux:separator class="my-2 border-zinc-800" />

                    <flux:sidebar.nav class="w-full space-y-1">
                        <flux:sidebar.group class="grid gap-1">
                            <div class="px-2 pb-2 text-[10px] font-bold uppercase tracking-widest text-zinc-500">
                                {{ __('Platform') }}
                            </div>

                            @if ($teamSlug)
                                <flux:sidebar.item icon="home" :href="route('dashboard', $teamSlug)" :current="request()->routeIs('dashboard')" wire:navigate>
                                    {{ __('Dashboard') }}
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="newspaper" :href="route('noticias.index', $teamSlug)" :current="request()->routeIs('noticias.*')" wire:navigate>
                                    {{ __('Noticias') }}
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="chat-bubble-left-right" :href="route('comentarios.index', $teamSlug)" :current="request()->routeIs('comentarios.*')" wire:navigate>
                                    {{ __('Comentarios') }}
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="user-group" :href="route('comunidad.index', $teamSlug)" :current="request()->routeIs('comunidad.*')" wire:navigate>
                                    {{ __('Comunidades') }}
                                </flux:sidebar.item>
                                <flux:sidebar.item icon="exclamation-triangle" :href="route('problemas.index', $teamSlug)" :current="request()->routeIs('problemas.*')" wire:navigate>
                                    {{ __('Problemas') }}
                                </flux:sidebar.item>
                            @else
                                <flux:sidebar.item icon="home" :href="route('home')" wire:navigate>
                                    {{ __('Inicio') }}
                                </flux:sidebar.item>
                            @endif
                        </flux:sidebar.group>
                    </flux:sidebar.nav>

                    <flux:spacer />

                    <!-- MENÚ DE USUARIO INFERIOR -->
                    <div class="space-y-4 border-t border-zinc-800/80 pt-4">
                        @auth
                            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
                        @endauth
                    </div>
                </nav>
            </aside>

            <!-- ================================================= -->
            <!-- CONTENEDOR DE LA VISTA PRINCIPAL                  -->
            <!-- ================================================= -->
            <div class="flex min-w-0 flex-1 flex-col">
                
                <!-- HEADER RESPONSIVO (MÓVILES) -->
                <flux:header class="border-b border-zinc-800 bg-zinc-900 px-4 py-2 lg:hidden">
                    <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />
                    <flux:spacer />
                </flux:header>

                <!-- ÁREA DE CONTENIDO DINÁMICO -->
                <main class="flex w-full flex-1 flex-col bg-zinc-950">
                    {{ $slot }}
                </main>
            </div>

        </div>

        <!-- MODALES Y COMPONENTES GLOBALES -->
        @auth
            <livewire:create-team-modal />
        @endauth

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>