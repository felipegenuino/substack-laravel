<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CommandPalette extends Component
{
    public $open = false;
    public $query = '';

    protected $listeners = [
        'toggleCommandPalette' => 'toggle',
    ];

    protected $commands = [
        ['key' => 'new_post', 'label' => 'New Post', 'href' => '/posts/new', 'hint' => 'N'],
        ['key' => 'new_note', 'label' => 'New Note', 'href' => '/notes/new', 'hint' => '⌘N'],
        ['key' => 'quick_note', 'label' => 'Quick Note', 'href' => '/notes/new?quick=1', 'hint' => 'Q'],
        ['key' => 'search', 'label' => 'Search', 'href' => '/search', 'hint' => '/'],
        ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => '/dashboard', 'hint' => 'D'],
    ];

    public function toggle()
    {
        $this->open = ! $this->open;
        if ($this->open) $this->dispatch('commandPaletteOpened');
    }

    public function open()
    {
        $this->open = true;
        $this->dispatch('commandPaletteOpened');
    }

    public function close()
    {
        $this->open = false;
    }

    public function run($key)
    {
        $cmd = collect($this->commands)->firstWhere('key', $key);

        if ($cmd && isset($cmd['href'])) {
            $this->close();
            $this->redirect($cmd['href']);
        }
    }

    public function getFilteredCommandsProperty()
    {
        $q = trim(strtolower($this->query));

        if ($q === '') return $this->commands;

        return array_values(array_filter($this->commands, function ($c) use ($q) {
            return str_contains(strtolower($c['label']), $q) || str_contains($c['key'], $q);
        }));
    }

    public function render()
    {
        return view('livewire.command-palette');
    }
}
