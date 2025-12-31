<?php

namespace App\Http\Livewire;

use App\Models\Content;
use Illuminate\Support\Str;
use Livewire\Component;

class Editor extends Component
{
    public $title;
    public $content;
    public $type = 'post';
    public $preview;
    public $lastAutosaveAt;
    public $publish_at;

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'content' => 'required|string',
        'type' => 'required|string',
        'publish_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->preview = '';
    }

    public function renderPreview()
    {
        // Use Parsedown if available
        if (class_exists('\\Parsedown')) {
            $parser = new \Parsedown();
            $this->preview = $parser->text($this->content ?? '');
        } else {
            // Fallback: basic conversion (very small subset)
            $text = $this->content ?? '';
            $text = preg_replace('/^# (.*?)$/m', '<h1>$1</h1>', $text);
            $text = preg_replace('/\*\*(.*?)\*\*/', '<strong>$1</strong>', $text);
            $this->preview = $text;
        }

        $this->dispatch('previewRendered');

        return $this->preview; 
    }

    public function save()
    {
        $this->validate();

        $status = 'draft';
        if ($this->publish_at) {
            $publishAt = \Illuminate\Support\Carbon::parse($this->publish_at);
            if ($publishAt->lte(now())) {
                $status = 'published';
            }
        }

        $content = Content::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->content,
            'status' => $status,
            'visibility' => 'public',
            'publish_at' => $this->publish_at,
        ]);

        $this->dispatch('saved', $content->id);

        return $content;
    }

    public function autosave()
    {
        $this->validateOnly('content');

        $content = Content::create([
            'user_id' => auth()->id(),
            'type' => $this->type,
            'title' => $this->title,
            'body' => $this->content,
            'status' => 'draft',
            'visibility' => 'public',
        ]);

        $this->lastAutosaveAt = now()->toDateTimeString();

        $this->dispatch('autosaved', $content->id);

        return $content;
    }

    public function updatedContent($value)
    {
        // Called after wire:model.debounce updates the property on the server
        $this->autosave();
    }

    public function render()
    {
        return view('livewire.editor');
    }
}
