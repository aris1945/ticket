<x-filament::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-6">
            Save Profile
        </x-filament::button>
    </form>
</x-filament::page>