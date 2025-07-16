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

   
    <x-filament::section icon="heroicon-o-building-office-2" collapsible collapsed>
        <x-slot name="heading">
            Company Bio
        </x-slot>
        <x-slot name="description">
            this is company bio which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyBioForm }}
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

    {{-- email form --}}
    <x-filament::section icon="heroicon-o-envelope" collapsible collapsed>
        <x-slot name="heading">
            Company Email
        </x-slot>
        <x-slot name="description">
            this is company email which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyEmailForm }}
    </x-filament::section>

    {{-- website form --}}
    <x-filament::section icon="heroicon-o-globe-alt" collapsible collapsed>
        <x-slot name="heading">
            Company Website
        </x-slot>
        <x-slot name="description">
            this is company website which will display in quotations, invoices and transactions
        </x-slot>
        {{ $this->CompanyWebsiteForm }}
    </x-filament::section>




</x-filament-panels::page>
