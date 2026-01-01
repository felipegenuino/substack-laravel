<div class="space-y-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Título</label>
        <input type="text" wire:model.lazy="title" class="mt-1 block w-full border rounded p-2" />
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Conteúdo</label>
        <textarea wire:model.debounce.2000ms="content" rows="10" class="mt-1 block w-full border rounded p-2"></textarea>
    </div>

    <div class="mt-3">
        <label class="block text-sm font-medium text-gray-700">Agendar publicação</label>
        <input type="datetime-local" wire:model="publish_at" class="mt-1 block w-64 border rounded p-2" />
        <p class="text-xs text-gray-500 mt-1">Deixe em branco para publicar imediatamente (ou salvar como rascunho).</p>
    </div>

    <div class="flex gap-2">
        <button wire:click.prevent="renderPreview" class="px-3 py-2 bg-gray-100 rounded">Preview</button>
        <button wire:click.prevent="save" class="px-3 py-2 bg-blue-600 text-white rounded">Salvar</button>
    </div>

    <div class="mt-2 text-sm text-gray-500" id="autosave-indicator">
        <span wire:loading wire:target="autosave">Salvando...</span>
        <span wire:loading.remove wire:target="autosave">Último salvamento: {{ $lastAutosaveAt ?? '—' }}</span>
    </div>

    <div class="mt-4">
        <h3 class="font-semibold">Preview</h3>
        <div class="prose mt-2" wire:ignore>
            {!! $preview ?? '' !!}
        </div>
    </div>
</div>
