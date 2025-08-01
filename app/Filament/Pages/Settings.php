<?php

namespace App\Filament\Pages;

use App\Services\Configuration;
use App\Traits\SettingPageActions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;

class Settings extends Page
{
    use InteractsWithForms, SettingPageActions;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string $view = 'filament.pages.settings';

    protected static bool $shouldRegisterNavigation = false;


    public array $settings = [];

    public function mount(): void
    {
        $this->fillForms();
    }

    protected function fillForms(): void
    {
        $this->settings = Configuration::asArray();
    }

    public function CompanyNameForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::COMPANY_NAME->value)
            ->schema([
                Tabs::make('Company name')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company name value')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::COMPANY_NAME->value]) ? $this->settings[\App\Enums\Settings::COMPANY_NAME->value]['en'] : ''
                                        )
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('إسم الشركة بالعربية')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::COMPANY_NAME->value]) ? $this->settings[\App\Enums\Settings::COMPANY_NAME->value]['ar'] : '' 
                                        )
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    public function CompanyBioForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::COMPANY_BIO->value)
            ->schema([
                Tabs::make('Company Bio')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company bio value')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::COMPANY_BIO->value]) ? $this->settings[\App\Enums\Settings::COMPANY_BIO->value]['en'] : ''
                                        )
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('شعار الشركة بالعربية')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::COMPANY_BIO->value]) ? $this->settings[\App\Enums\Settings::COMPANY_BIO->value]['ar'] : '' 
                                        )
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }


    public function CompanyAddressForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::ADDRESS->value)
            ->schema([
                Tabs::make('Company Address')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company adress value')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::ADDRESS->value]) ? $this->settings[\App\Enums\Settings::ADDRESS->value]['en'] : ''
                                        )
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('عنوان الشركة بالعربية')
                                    ->default(
                                        isset($this->settings[\App\Enums\Settings::ADDRESS->value]) ? $this->settings[\App\Enums\Settings::ADDRESS->value]['ar'] : ''
                                        )
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    public function CompanyVatForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::VAT_NUMBER->value)
            ->schema([
                Tabs::make('Company VAT Number')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company VAT Number')
                                    ->default($this->settings[\App\Enums\Settings::VAT_NUMBER->value]['en'] ?? '')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('الرقم الضريبي للشركة بالعربية')
                                    ->default($this->settings[\App\Enums\Settings::VAT_NUMBER->value]['ar'] ?? '')
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    public function CompanyCRForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::CR_NUMBER->value)
            ->schema([
                Tabs::make('Company Address')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company CR Numbet')
                                    ->default($this->settings[\App\Enums\Settings::CR_NUMBER->value]['en'] ?? '')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('عنوان الشركة بالعربية')
                                    ->default($this->settings[\App\Enums\Settings::ADDRESS->value]['ar'] ?? '')
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    public function CompanyWebsiteForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::WEBSITE->value)
            ->schema([
                Tabs::make('Company Website')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company website')
                                    ->default($this->settings[\App\Enums\Settings::WEBSITE->value]['en'] ?? '')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('موقع الشركة بالعربية')
                                    ->default($this->settings[\App\Enums\Settings::WEBSITE->value]['ar'] ?? '')
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    public function CompanyEmailForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings.'.\App\Enums\Settings::EMAIL->value)
            ->schema([
                Tabs::make('Company Email')
                    ->schema([
                        Tabs\Tab::make('en')
                            ->label('EN')
                            ->schema([
                                TextInput::make('en')
                                    ->label('company email')
                                    ->default($this->settings[\App\Enums\Settings::EMAIL->value]['en'] ?? '')
                                    ->required(),
                            ]),
                        Tabs\Tab::make('ar')
                            ->label('AR')
                            ->schema([
                                TextInput::make('ar')
                                    ->label('البريد الإلكتروني للشركة بالعربية')
                                    ->default($this->settings[\App\Enums\Settings::EMAIL->value]['ar'] ?? '')
                                    ->required(),
                            ]),
                    ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('save'),
                ]),
            ]);
    }

    protected function getForms(): array
    {
        return [
            'CompanyNameForm',
            'CompanyAddressForm',
            'CompanyVatForm',
            'CompanyCRForm',
            'CompanyBioForm',
            'CompanyWebsiteForm',
            'CompanyEmailForm',
        ];
    }
}
