<div x-data="{ open: @entangle('open'), query: @entangle('query'), selected: 0 }"
     x-init="$watch('open', value => { if (value) { selected = 0; $nextTick(() => { const input = $el.querySelector('input'); if (input) input.focus(); }); } })"
     x-on:keydown.window="if (!open) return; if ($event.key === 'ArrowDown') { const count = $el.querySelectorAll('ul li').length; selected = Math.min(selected + 1, count - 1); $event.preventDefault(); } else if ($event.key === 'ArrowUp') { selected = Math.max(selected - 1, 0); $event.preventDefault(); } else if ($event.key === 'Enter') { const btn = $el.querySelectorAll('ul li button')[selected]; if (btn) btn.click(); }">

    <template x-if="open">
        <div class="fixed inset-0 z-50 flex items-start justify-center p-4">
            <div class="absolute inset-0 bg-black/40" wire:click="close"></div>

            <div class="relative w-full max-w-xl bg-white rounded shadow-lg p-4">
                <input wire:model.debounce.300ms="query" autofocus class="w-full border rounded p-2" placeholder="Type a command..." />

                <ul class="mt-3 space-y-2">
                    @foreach($this->filteredCommands as $cmd)
                    <li :class="selected === {{ $loop->index }} ? 'bg-gray-100' : ''" class="rounded">
                        <button wire:click="run('{{ $cmd['key'] }}')" data-key="{{ $cmd['key'] }}" class="w-full text-left px-3 py-2 rounded">{{ $cmd['label'] }}</button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </template>

</div>
