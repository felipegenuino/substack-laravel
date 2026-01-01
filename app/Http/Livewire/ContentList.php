<?php

namespace App\Http\Livewire;

use App\Models\Content;
use Livewire\Component;
use Livewire\WithPagination;

class ContentList extends Component
{
    use WithPagination;

    public $selected = 0;
    public $filter = 'all'; // all, published, draft

    protected $listeners = [
        'refreshContentList' => '$refresh',
    ];

    public function updatedFilter()
    {
        $this->resetPage();
        $this->selected = 0;
    }

    public function selectPrev()
    {
        $this->selected = max(0, $this->selected - 1);
    }

    public function selectNext()
    {
        $count = $this->getContentsProperty()->count();
        $this->selected = min($count - 1, $this->selected + 1);
    }

    public function openSelected()
    {
        $contents = $this->getContentsProperty();
        if ($contents->isNotEmpty() && isset($contents[$this->selected])) {
            $content = $contents[$this->selected];
            return $this->redirect(route('content.edit', $content->id));
        }
    }

    public function deleteSelected()
    {
        $contents = $this->getContentsProperty();
        if ($contents->isNotEmpty() && isset($contents[$this->selected])) {
            $content = $contents[$this->selected];
            $content->delete();
            $this->dispatch('refreshContentList');
        }
    }

    public function getContentsProperty()
    {
        $query = Content::where('user_id', auth()->id())
            ->orderBy('updated_at', 'desc');

        if ($this->filter === 'published') {
            $query->where('status', 'published');
        } elseif ($this->filter === 'draft') {
            $query->where('status', 'draft');
        }

        return $query->take(20)->get();
    }

    /**
     * Calculate reading time in minutes.
     */
    public static function readingTime(?string $body): int
    {
        if (empty($body)) {
            return 1;
        }
        $wordCount = str_word_count(strip_tags($body));
        $minutes = max(1, (int) ceil($wordCount / 200));
        return $minutes;
    }

    public function render()
    {
        return view('livewire.content-list', [
            'contents' => $this->contents,
        ]);
    }
}
