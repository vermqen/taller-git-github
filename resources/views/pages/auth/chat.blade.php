<x-layouts::app :title="__('Chat with :user', ['user' => $recipient->name])">
    <div class="mx-auto w-full max-w-4xl space-y-6 p-6 lg:p-10">
        <header class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.18em] text-amber-600">{{ __('Private chat') }}</p>
                <h1 class="mt-2 text-3xl font-bold text-zinc-900 dark:text-white">{{ $recipient->name }}</h1>
            </div>
            <a href="{{ url()->previous() }}" class="text-sm font-semibold text-amber-600 hover:underline">{{ __('Back') }}</a>
        </header>

        <section class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900" aria-label="{{ __('Conversation messages') }}">
            <div class="flex min-h-96 flex-col gap-3 overflow-y-auto" id="messagesBox">
                @forelse ($messages as $message)
                    <div class="message-bubble {{ $message->id_emisor === auth()->id() ? 'message-outgoing self-end' : 'message-incoming self-start' }}">
                        {{ $message->contenido }}
                        <span class="message-time">{{ $message->fecha_envio?->format('H:i') }}</span>
                    </div>
                @empty
                    <p class="m-auto text-sm text-zinc-500">{{ __('No messages yet.') }}</p>
                @endforelse
            </div>

            <form method="POST" action="{{ route('chat.store', $recipient) }}" class="mt-5 flex gap-3">
                @csrf
                <label for="contenido" class="sr-only">{{ __('Message') }}</label>
                <input id="contenido" name="contenido" type="text" maxlength="5000" required autofocus
                       value="{{ old('contenido') }}" placeholder="{{ __('Write a message...') }}"
                       class="min-w-0 flex-1 rounded-lg border border-zinc-300 bg-white px-3 py-2 text-zinc-900 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white">
                <button type="submit" class="rounded-lg bg-amber-500 px-4 py-2 font-semibold text-zinc-950 hover:bg-amber-400">
                    {{ __('Send') }}
                </button>
            </form>

            @error('contenido')
                <p role="alert" class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </section>
    </div>
</x-layouts::app>
