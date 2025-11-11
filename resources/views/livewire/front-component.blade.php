<div class="flex flex-col min-h-screen"
     x-data
     @keydown.window.meta.k.prevent="document.getElementById('search-input')?.focus()"
     @keydown.window.ctrl.k.prevent="document.getElementById('search-input')?.focus()"
>
    <flux:header container sticky class="bg-orange-500 dark:bg-zinc-900 py-4">

        {{-- Text color forced in app.css --}}
        <flux:brand href="#" name="{{ config('app.name') }}">
            <x-slot name="logo">
                <div class="size-8 rounded shrink-0 text-white flex items-center justify-center">
                    <flux:icon.at-symbol/>
                </div>
            </x-slot>
        </flux:brand>

        <flux:input kbd="⌘K" icon="magnifying-glass"
                    placeholder="{{ __('Search...') }}"
                    wire:model.live.debounce="search"
                    class="mx-8"
                    size="sm"
                    id="search-input"
        />

        <div class="flex space-x-4">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance"
                              class="dark:[&_[data-checked]]:bg-accent">
                <flux:radio value="light" icon="sun"/>
                <flux:radio value="dark" icon="moon"/>
            </flux:radio.group>

            <flux:radio.group x-data variant="segmented" wire:model.live="locale"
                              class="dark:[&_[data-checked]]:bg-accent">
                <flux:radio value="es" label="Es"/>
                <flux:radio value="en" label="En"/>
            </flux:radio.group>
        </div>
    </flux:header>

    <div container class="flex-grow bg-orange-500 dark:bg-zinc-900">
        <flux:main container class="">
            <div class="columns-1 md:columns-2 lg:columns-3 xl:columns-4 gap-6 space-y-6">
                @foreach($this->cards as $card)
                    <flux:card class="break-inside-avoid space-y-6" wire:key="card-{{ $card->id }}">
                        @if($card->hasMedia())
                            <flux:modal.trigger name="card-detail-{{ $card->id }}" class="block -mb-4">
                                <img src="{{ $card->getFirstMediaUrl(conversionName: 'preview') }}"
                                     alt="{{ $card->title }}"
                                     class="w-full h-auto object-cover rounded-lg cursor-pointer mb-4">
                            </flux:modal.trigger>
                        @endif

                        <flux:heading size="lg" class="mb-2">{{ $card->title }}</flux:heading>
                        <flux:text>{{ $card->text }}</flux:text>

                        @if($card->hasMedia())
                            <flux:modal name="card-detail-{{ $card->id }}" class="w-full max-w-sm md:max-w-xl lg:max-w-4xl">
                                <div class="space-y-6">
                                    <flux:heading size="lg">{{ $card->title }}</flux:heading>

                                    <img src="{{ $card->getFirstMediaUrl() }}"
                                         alt="{{ $card->title }}"
                                         class="w-full h-auto object-cover rounded-lg">

                                    <flux:text>{{ $card->text }}</flux:text>
                                </div>
                            </flux:modal>
                        @endif

                        @foreach($card->tags as $tag)
                            <flux:badge size="xs" color="orange">#{{ $tag->name }}</flux:badge>
                        @endforeach
                    </flux:card>
                @endforeach
            </div>
        </flux:main>
    </div>

    @if($this->hasMore)
        <div class="bg-orange-500 dark:bg-zinc-900 flex justify-center items-center">
            <div x-intersect="$wire.loadMoreCards()" class="h-1"></div>

            <div wire:loading wire:target="loadMoreCards" class="py-4">
                <flux:icon.loading/>
            </div>
        </div>
    @endif


    <footer class="sticky bottom-0 bg-accent/90 text-white dark:text-accent-content px-8 py-4 flex justify-between">
        <div class="text-xs">{{ config('app.name') }}</div>
        <div class="text-xs">{{ __('Developed by') }}
            <a href="https://arzcode.com" target="_blank" class="underline decoration-orange-500">arzcode.com</a>
        </div>
    </footer>
</div>
