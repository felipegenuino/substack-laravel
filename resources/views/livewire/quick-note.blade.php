<div class="space-y-3">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nota rápida (sem título obrigatório)</label>
        <textarea wire:model="body" rows="4" class="mt-1 block w-full border rounded p-2" placeholder="Escreva algo rápido..."></textarea>
    </div>

    <div>
        <input type="text" wire:model.lazy="title" class="mt-1 block w-full border rounded p-2" placeholder="Título (opcional)" />
    </div>

    <div class="flex gap-2">
        <button wire:click.prevent="save" class="px-3 py-2 bg-blue-600 text-white rounded">Salvar Nota</button>
    </div>
</div>
