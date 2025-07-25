<x-filament-widgets::widget>
    <div class="w-full flex justify-end items-center gap-2">
        <x-filament::button
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ $this->getGenerateQuotationUrl() }}"
            color="primary">
            generate quotation
        </x-filament::button>
        <x-filament::button
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ $this->getGenerateInvoiceUrl() }}"
            color="success">
            generate invoice
        </x-filament::button>
        <x-filament::button
            tag="a"
            :openInNewTab="true"
            target="_blank"
            href="{{ $this->getGenerateReceiptUrl() }}"
            color="danger">
            generate receipt
        </x-filament::button>
    </div>
</x-filament-widgets::widget>
