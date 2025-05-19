<?php

namespace App\Filament\Pages;

use App\Traits\SettingPageActions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Pixelpeter\FilamentLanguageTabs\Forms\Components\LanguageTabs;

class Settings extends Page
{
    use InteractsWithForms, SettingPageActions;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string $view = 'filament.pages.settings';

    public array $settings = [];


    public function CompanyNameForm(Form $form): Form
    {
        return $form
                ->operation('create')
                ->statePath('settings')
                ->schema([
                    Hidden::make('key')
                        ->default('company_name')
                        ->label('company name'),
                    LanguageTabs::make([
                        TextInput::make('value')
                            ->label('value'),
                    ]),
                    \Filament\Forms\Components\Actions::make([
                        Action::make('save')
                            ->action('create')
                    ])
                ]);
    }

    public function CompanyAddressForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings')
            ->schema([
                Hidden::make('key')
                    ->default('company_name')
                    ->label('company name'),
                LanguageTabs::make([
                    TextInput::make('value')
                        ->label('value'),
                ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('create')
                ])
            ]);
    }

    public function CompanyVatForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings')
            ->schema([
                Hidden::make('key')
                    ->default('company_name')
                    ->label('company name'),
                LanguageTabs::make([
                    TextInput::make('value')
                        ->label('value'),
                ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('create')
                ])
            ]);
    }

    public function CompanyCRForm(Form $form): Form
    {
        return $form
            ->operation('create')
            ->statePath('settings')
            ->schema([
                Hidden::make('key')
                    ->default('company_name')
                    ->label('company name'),
                LanguageTabs::make([
                    TextInput::make('value')
                        ->label('value'),
                ]),
                \Filament\Forms\Components\Actions::make([
                    Action::make('save')
                        ->action('create')
                ])
            ]);
    }

    protected function getForms(): array
    {
        return [
            'CompanyNameForm',
            'CompanyAddressForm',
            'CompanyVatForm',
            'CompanyCRForm'
        ];
    }
}
