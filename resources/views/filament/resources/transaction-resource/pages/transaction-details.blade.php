<x-filament-panels::page>
    {{ $this->infolist }}
    {{ $this->quotationInfolist }}
    @if($this->hasQuotation)
        {{ $this->table }}
    @else
        <div class="text-center font-semibold text-lg text-danger-600 py-2">
            no quotation found, create one first
        </div>
    @endif
</x-filament-panels::page>
