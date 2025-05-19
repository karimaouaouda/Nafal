<x-filament-widgets::widget>
    <x-filament::section>
        @vite('resources/css/app.css')
        {{-- quotation information and edit action --}}
        @if( $quotation )
            <div class="w-full flex flex-col space-y-1">
                <div class="flex flex-row justify-between items-center">
                    <div class="flex flex-col">
                        <h2 class="text-lg font-bold text-gray-800">Quotation Details</h2>
                        <p class="text-sm text-gray-600">Quotation ID: {{ $record->id }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <x-filament::link
                            color="primary"
                            icon="heroicon-o-pencil"
                            size="sm"
                            href="{{ route('filament.admin.resources.quotations.edit', ['record' => $quotation->id]) }}">
                            Edit
                        </x-filament::link>
                        <x-filament::link
                            color="secondary"
                            icon="heroicon-o-plus"
                            class="bg-blue-500 text-white rounded px-2 py-1 hover:bg-blue-600"
                            size="sm"
                            href="{{ route('filament.admin.resources.quotations.edit', ['record' => $quotation->id]) }}">
                            Edit Products
                        </x-filament::link>
                    </div>
                </div>
                <div class="flex flex-col space-y-2">
                    <p class="text-sm text-gray-700">Customer Name: {{ $record->customer->latin_name }} / {{ $record->customer->arabic_name }}</p>
                    <p class="text-sm text-gray-700">Total Amount: 240</p>
                </div>

            </div>
        @else
            <p class="w-full text-center py-2 text-danger-600 font-semibold">
                no quotation yet,  create on
            </p>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
