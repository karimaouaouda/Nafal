<x-filament-panels::page>
    <x-filament::section icon="heroicon-o-building-office-2" collapsible collapsed>
        <x-slot name="heading">
            Company Name
        </x-slot>
        <x-slot name="description">
            this is company name which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyNameForm }}
    </x-filament::section>
    <x-filament::section icon="heroicon-o-map-pin" collapsible collapsed>
        <x-slot name="heading">
            Company Address
        </x-slot>
        <x-slot name="description">
            this is company address which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyAddressForm }}
    </x-filament::section>

    <x-filament::section icon="heroicon-o-credit-card" collapsible collapsed>
        <x-slot name="heading">
            Company  Value Added Tax identification number (VAT)
        </x-slot>
        <x-slot name="description">
            this is Company  Value Added Tax identification number (VAT) which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyVatForm }}
    </x-filament::section>

    <x-filament::section icon="heroicon-o-credit-card" collapsible collapsed>
        <x-slot name="heading">
            Commercial Registration Number (C.R)
        </x-slot>
        <x-slot name="description">
            this is Company  Commercial Registration Number (CR) which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyCRForm }}
    </x-filament::section>


</x-filament-panels::page>
