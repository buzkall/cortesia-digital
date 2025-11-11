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
    private int $limit = 10;
    private int $perPage = 10;
    public array $cardIds = [];

    #[Computed]
    public function cards(): Collection
    {
        return Card::query()
            ->with('tags')
            ->when($this->search, fn($query) => $query->search($this->search))
            ->orderByDesc('created_at')
            ->limit($this->limit)
            ->get();
    }

    #[Computed]
    public function hasMore(): bool
    {
        return $this->cards->count() === $this->limit;
    }

    public function mount(): void
    {
        $this->locale = session('locale', app()->getLocale());
        app()->setLocale($this->locale);
    }

    public function updatedLocale($value): void
    {
        session(['locale' => $value]);
        app()->setLocale($value);
    }

    public function loadMoreCards(): void
    {
        if (! $this->hasMore) {
            return;
        }

        $this->limit += $this->perPage;

        // Clear computed property cache to force re-evaluation
        unset($this->cards);
        unset($this->hasMore);
    }

    public function render(): View
    {
        return view('livewire.front-component');
    }
}
