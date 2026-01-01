<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Seus Conteúdos</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400">Gerencie suas notas e posts</p>
            </div>
            <div class="flex items-center gap-2">
                <a
                    href="{{ route('notes.new') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition"
                >
                    <flux:icon.plus class="size-4" />
                    Nova Nota
                </a>
            </div>
        </div>

        {{-- Stats cards --}}
        <div class="grid gap-4 sm:grid-cols-3">
            @php
                $totalContents = auth()->user()->contents()->count();
                $publishedCount = auth()->user()->contents()->where('status', 'published')->count();
                $draftCount = auth()->user()->contents()->where('status', 'draft')->count();
            @endphp

            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30">
                        <flux:icon.file-text class="size-5 text-blue-600 dark:text-blue-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $totalContents }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Total</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-green-100 dark:bg-green-900/30">
                        <flux:icon.check-circle class="size-5 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $publishedCount }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Publicados</p>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-800">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg bg-yellow-100 dark:bg-yellow-900/30">
                        <flux:icon.pencil class="size-5 text-yellow-600 dark:text-yellow-400" />
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $draftCount }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Rascunhos</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Content list with keyboard navigation --}}
        <div class="flex-1">
            @livewire('content-list')
        </div>
    </div>
</x-layouts.app>
