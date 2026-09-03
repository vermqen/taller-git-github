<x-layouts::app.encabezado :title="$title ?? null">
    <flux:main class="w-full max-w-none !p-0">
        {{ $slot }}
    </flux:main>
</x-layouts::app.encabezado>