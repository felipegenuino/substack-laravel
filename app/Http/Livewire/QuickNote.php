<?php

namespace App\Http\Livewire;

use App\Models\Content;
use Livewire\Component;

class QuickNote extends Component
{
    public $title;
    public $body;

    protected $rules = [
        'body' => 'required|string',
        'title' => 'nullable|string|max:255',
    ];

    public function save()
    {
        $this->validate();

        $content = Content::create([
            'user_id' => auth()->id(),
            'type' => 'note',
            'title' => $this->title,
            'body' => $this->body,
            'status' => 'published', // notes are published by default in quick flow
            'visibility' => 'public',
        ]);

        $this->reset(['title', 'body']);

        $this->dispatch('noteSaved', $content->id);

        return $content;
    }

    public function render()
    {
        return view('livewire.quick-note');
    }
}
