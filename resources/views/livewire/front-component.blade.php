<div class="flex flex-col min-h-screen">
    <flux:header container sticky class="bg-orange-500 dark:bg-zinc-900">

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
                    class="mx-8"
                    size="sm"
        />

        <div class="flex space-x-4">
            <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
                <flux:radio value="light" icon="sun"/>
                <flux:radio value="dark" icon="moon"/>
            </flux:radio.group>

            <flux:radio.group x-data variant="segmented" wire:model="locale" wire:click="changeLocale">
                <flux:radio value="es" label="Es"/>
                <flux:radio value="en" label="En"/>
            </flux:radio.group>
        </div>

    </flux:header>

    <flux:main container class="flex-1 bg-orange-500 dark:bg-zinc-900">

        <flux:text class="mt-2 mb-6 text-base">Foreach cards</flux:text>
        {{ $this->locale }}
    </flux:main>


</div>
