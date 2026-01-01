<div
    x-data="{ selected: @entangle('selected') }"
    x-on:keydown.j.window.prevent="$wire.selectNext()"
    x-on:keydown.k.window.prevent="$wire.selectPrev()"
    x-on:keydown.enter.window="$wire.openSelected()"
    x-on:keydown.delete.window="$wire.deleteSelected()"
    class="space-y-4"
>
    {{-- Filter tabs --}}
    <div class="flex items-center gap-2 border-b border-zinc-200 dark:border-zinc-700 pb-2">
        <button
            wire:click="$set('filter', 'all')"
            class="px-3 py-1 text-sm rounded-lg transition {{ $filter === 'all' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
        >
            Todos
        </button>
        <button
            wire:click="$set('filter', 'published')"
            class="px-3 py-1 text-sm rounded-lg transition {{ $filter === 'published' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
        >
            Publicados
        </button>
        <button
            wire:click="$set('filter', 'draft')"
            class="px-3 py-1 text-sm rounded-lg transition {{ $filter === 'draft' ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800' }}"
        >
            Rascunhos
        </button>

        <div class="ml-auto text-xs text-zinc-400">
            <kbd class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded">j</kbd>/<kbd class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded">k</kbd> navegar
            <kbd class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded ml-2">Enter</kbd> abrir
        </div>
    </div>

    {{-- Content list --}}
    @forelse($contents as $index => $content)
        <div
            wire:key="content-{{ $content->id }}"
            x-bind:class="selected === {{ $index }} ? 'ring-2 ring-blue-500 dark:ring-blue-400' : ''"
            class="group flex items-start gap-4 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 transition cursor-pointer hover:border-zinc-300 dark:hover:border-zinc-600"
            wire:click="$set('selected', {{ $index }})"
            x-on:dblclick="$wire.openSelected()"
        >
            {{-- Type badge --}}
            <div class="shrink-0 mt-1">
                @switch($content->type)
                    @case('note')
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            <flux:icon.book-open-text class="size-4" />
                        </span>
                        @break
                    @case('post')
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <flux:icon.file-text class="size-4" />
                        </span>
                        @break
                    @default
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-700 text-zinc-500">
                            <flux:icon.file class="size-4" />
                        </span>
                @endswitch
            </div>

            {{-- Content info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h3 class="font-medium text-zinc-900 dark:text-white truncate">
                        {{ $content->title ?: 'Sem título' }}
                    </h3>
                    @if($content->status === 'draft')
                        <span class="shrink-0 px-2 py-0.5 text-xs font-medium rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                            Rascunho
                        </span>
                    @elseif($content->status === 'scheduled')
                        <span class="shrink-0 px-2 py-0.5 text-xs font-medium rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                            Agendado
                        </span>
                    @endif
                </div>

                <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                    {{ Str::limit(strip_tags($content->body), 120) }}
                </p>

                <div class="mt-2 flex items-center gap-3 text-xs text-zinc-400 dark:text-zinc-500">
                    <span>{{ $content->updated_at->diffForHumans() }}</span>
                    <span>·</span>
                    <span>{{ \App\Http\Livewire\ContentList::readingTime($content->body) }} min de leitura</span>
                    @if($content->visibility === 'private')
                        <span>·</span>
                        <span class="inline-flex items-center gap-1">
                            <flux:icon.lock class="size-3" /> Privado
                        </span>
                    @endif
                </div>
            </div>

            {{-- Actions --}}
            <div class="shrink-0 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                <a
                    href="{{ route('content.edit', $content->id) }}"
                    class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700 text-zinc-500 dark:text-zinc-400"
                    title="Editar"
                >
                    <flux:icon.pencil class="size-4" />
                </a>
                <button
                    wire:click.stop="deleteSelected"
                    class="p-2 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 text-zinc-500 dark:text-zinc-400 hover:text-red-600 dark:hover:text-red-400"
                    title="Excluir"
                >
                    <flux:icon.trash class="size-4" />
                </button>
            </div>
        </div>
    @empty
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center mb-4">
                <flux:icon.file-text class="size-8 text-zinc-400" />
            </div>
            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">Nenhum conteúdo ainda</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">Crie sua primeira nota ou post para começar.</p>
            <a href="{{ route('notes.new') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <flux:icon.plus class="size-4" />
                Nova Nota
            </a>
        </div>
    @endforelse
</div>
