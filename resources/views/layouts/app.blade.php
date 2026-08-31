<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main class="w-full max-w-none !p-0">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>