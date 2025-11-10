<?php

namespace App\Livewire;

use App\Models\Card;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FrontComponent extends Component
{
    public string $locale;
    public ?string $search = null;
    public bool $loading = false;
    public int $offset = 0;
    private int $limit = 10;
    private int $perPage = 10;
    public array $cardIds = [];
    public bool $hasMore = true;

    #[Computed]
    public function cards(): Collection
    {
        return Card::query()
            ->with('tags')
            ->when($this->search, fn($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->orderByDesc('created_at')
            ->limit($this->limit)
            ->get();
    }

    public function mount(): void
    {
        $this->locale = app()->getLocale();

        $this->hasMore = $this->cards->count() === $this->limit;
    }

    public function changeLocale(): void
    {
        app()->setLocale($this->locale);
    }

    public function loadMoreCards(): void
    {
        if (! $this->hasMore || $this->loading) {
            return;
        }

        $this->loading = true;
        $this->limit += $this->perPage;
        $this->hasMore = $this->cards->count() === $this->limit;
        $this->loading = false;
    }

    public function render(): View
    {
        return view('livewire.front-component');
    }
}
