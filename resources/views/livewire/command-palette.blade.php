<div x-data class="">
    @if($open)
    <div class="fixed inset-0 z-50 flex items-start justify-center p-4">
        <div class="absolute inset-0 bg-black/40" wire:click="close"></div>

        <div class="relative w-full max-w-xl bg-white rounded shadow-lg p-4">
            <input wire:model.debounce.300ms="query" autofocus class="w-full border rounded p-2" placeholder="Type a command..." />

            <ul class="mt-3 space-y-2">
                @foreach($this->filteredCommands as $cmd)
                <li>
                    <button wire:click="run('{{ $cmd['key'] }}')" class="w-full text-left px-3 py-2 rounded hover:bg-gray-100">{{ $cmd['label'] }}</button>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif
</div>
