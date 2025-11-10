<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class FrontComponent extends Component
{
    public string $locale;

    public function mount(): void
    {
        $this->locale = app()->getLocale();
    }

    public function changeLocale()
    {
        app()->setLocale($this->locale);
    }

    public function render(): View
    {
        return view('livewire.front-component');
    }
}
