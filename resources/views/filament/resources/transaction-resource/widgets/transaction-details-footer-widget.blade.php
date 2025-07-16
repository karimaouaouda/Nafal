<x-filament-widgets::widget>
    <div class="w-full flex justify-end items-center gap-2">
        <x-filament::button 
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ route('quotation.pdf', ['quotation' => $record->quotation]) }}"
            color="primary">
            see receipt
        </x-filament::button>
        <x-filament::button 
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ route('quotation.pdf', ['quotation' => $record->quotation]) }}"
            color="primary">
            see receipt
        </x-filament::button>
        <x-filament::button 
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ route('quotation.pdf', ['quotation' => $record->quotation]) }}"
            color="primary">
            see receipt
        </x-filament::button>
    </div>
</x-filament-widgets::widget>