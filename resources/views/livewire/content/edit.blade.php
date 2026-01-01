<?php

use App\Models\Content;
use Livewire\Volt\Component;
use function Livewire\Volt\{state, mount, rules};

new class extends Component
{
    public Content $content;
    public string $title = '';
    public string $body = '';
    public string $status = 'draft';
    public string $visibility = 'public';
    public ?string $publish_at = null;

    public function mount(Content $content): void
    {
        // Ensure user owns the content
        abort_unless($content->user_id === auth()->id(), 403);

        $this->content = $content;
        $this->title = $content->title ?? '';
        $this->body = $content->body ?? '';
        $this->status = $content->status;
        $this->visibility = $content->visibility;
        $this->publish_at = $content->publish_at?->format('Y-m-d\TH:i');
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'status' => 'required|in:draft,published,scheduled',
            'visibility' => 'required|in:public,private',
            'publish_at' => 'nullable|date',
        ];
    }

    public function save(): void
    {
        $this->validate();

        $this->content->update([
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'visibility' => $this->visibility,
            'publish_at' => $this->publish_at,
        ]);

        session()->flash('message', 'Conteúdo salvo com sucesso!');
    }

    public function publish(): void
    {
        $this->status = 'published';
        $this->save();

        $this->redirect(route('dashboard'), navigate: true);
    }

    public function delete(): void
    {
        $this->content->delete();

        session()->flash('message', 'Conteúdo excluído.');
        $this->redirect(route('dashboard'), navigate: true);
    }

    public static function readingTime(?string $body): int
    {
        if (!$body) return 1;
        $wordCount = str_word_count(strip_tags($body));
        return max(1, (int) ceil($wordCount / 200));
    }
}

?>

<x-layouts.app>
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 dark:text-zinc-400">
                    <flux:icon.arrow-left class="size-5" />
                </a>
                <div>
                    <h1 class="text-xl font-semibold text-zinc-900 dark:text-white">Editar {{ $content->type === 'note' ? 'Nota' : 'Post' }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ $this->readingTime($body) }} min de leitura</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <button
                    wire:click="save"
                    class="px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-700 rounded-lg hover:bg-zinc-200 dark:hover:bg-zinc-600 transition"
                >
                    Salvar rascunho
                </button>
                <button
                    wire:click="publish"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition"
                >
                    @if($status === 'published')
                        Atualizar
                    @else
                        Publicar
                    @endif
                </button>
            </div>
        </div>

        {{-- Flash message --}}
        @if(session('message'))
            <div class="mb-6 px-4 py-3 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        {{-- Editor --}}
        <div class="space-y-6">
            {{-- Title --}}
            <div>
                <input
                    type="text"
                    wire:model.blur="title"
                    placeholder="Título (opcional)"
                    class="w-full text-3xl font-bold border-0 bg-transparent text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-zinc-500 focus:ring-0 focus:outline-none"
                />
            </div>

            {{-- Body --}}
            <div>
                <textarea
                    wire:model.blur="body"
                    placeholder="Comece a escrever..."
                    rows="20"
                    class="w-full text-lg leading-relaxed border-0 bg-transparent text-zinc-700 dark:text-zinc-300 placeholder-zinc-400 dark:placeholder-zinc-500 focus:ring-0 focus:outline-none resize-none"
                ></textarea>
            </div>
        </div>

        {{-- Metadata panel --}}
        <div class="mt-8 p-6 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-white mb-4">Configurações</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                    <select
                        wire:model="status"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="draft">Rascunho</option>
                        <option value="published">Publicado</option>
                        <option value="scheduled">Agendado</option>
                    </select>
                </div>

                {{-- Visibility --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Visibilidade</label>
                    <select
                        wire:model="visibility"
                        class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="public">Público</option>
                        <option value="private">Privado</option>
                    </select>
                </div>

                {{-- Publish date (when scheduled) --}}
                @if($status === 'scheduled')
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Publicar em</label>
                        <input
                            type="datetime-local"
                            wire:model="publish_at"
                            class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-700 border border-zinc-300 dark:border-zinc-600 rounded-lg text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                        />
                    </div>
                @endif
            </div>

            {{-- Delete button --}}
            <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                <button
                    wire:click="delete"
                    wire:confirm="Tem certeza que deseja excluir este conteúdo? Esta ação não pode ser desfeita."
                    class="text-sm text-red-600 dark:text-red-400 hover:underline"
                >
                    Excluir conteúdo
                </button>
            </div>
        </div>

        {{-- Keyboard shortcuts hint --}}
        <div class="mt-6 text-center text-xs text-zinc-400 dark:text-zinc-500">
            <kbd class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded">⌘S</kbd> salvar
            <span class="mx-2">·</span>
            <kbd class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-700 rounded">Esc</kbd> voltar
        </div>
    </div>

    {{-- Keyboard shortcuts --}}
    @script
    <script>
        document.addEventListener('keydown', (e) => {
            // Cmd/Ctrl + S to save
            if ((e.metaKey || e.ctrlKey) && e.key === 's') {
                e.preventDefault();
                $wire.save();
            }
            // Esc to go back (only if not in input)
            if (e.key === 'Escape' && !['INPUT', 'TEXTAREA'].includes(document.activeElement.tagName)) {
                window.location.href = '{{ route('dashboard') }}';
            }
        });
    </script>
    @endscript
</x-layouts.app>
