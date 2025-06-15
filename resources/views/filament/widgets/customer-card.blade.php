<x-filament-widgets::widget>
    <x-filament::section collapsible>
        <x-slot name="heading">
            Customer Information
        </x-slot>
        <x-slot name="description">
            Overview on the customer who the transaction with
        </x-slot>
        <x-slot name="icon">
            <x-heroicon-o-user/>
        </x-slot>

        @vite('resources/css/app.css')
        <div class=" p-2">
            <div class="flex items-start space-x-4 mb-6">
                <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center">
                    <img src="{{ $customer->logo_url }}" alt="Customer Logo" class="w-20 h-20 object-contain">
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $customer->arabic_name }}</h2>
                    <p class="text-gray-600">{{ $customer->latin_name }}</p>
                    <div class="mt-2 flex space-x-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Special #: {{ $customer->customer_number }}
                        </span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            VAT #: {{ $customer->vat_number }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Address Information</h3>
                    <div class="space-y-2 text-gray-600">
                        <p>{{ $customer->address->street_line_1 }}</p>
                        @if($customer->address->street_line_2)
                            <p>{{ $customer->street_line_2 }}</p>
                        @endif
                        <p>{{ $customer->address->state->name }}, {{ $customer->address->city->name }}</p>
                        <p>{{ $customer->address->country->name }} - {{ $customer->address->zip_code }}</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Contact Information</h3>
                    <div class="space-y-2 text-gray-600">
                        <p>{{ $customer->contact->phone_number }}</p>
                        <p>{{ $customer->contact->email }}</p>
                        @if($customer->contact->website)
                            <a href="{{ $customer->website }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ $customer->contact->website }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
