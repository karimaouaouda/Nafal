<?php

namespace App\Filament\Pages\Override;

use Filament\Actions\Action;
use Filament\Support\Colors\Color;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        $actions = [];

        $actions[] = Action::make('create transaction')
                        ->color(Color::Blue)
                        ->action(function(){
                            dd("hi");
                        });
        return $actions;
    }
}
