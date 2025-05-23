<?php

namespace App\Traits;

use App\Services\Configuration;
use Filament\Notifications\Notification;
use JetBrains\PhpStorm\NoReturn;

trait SettingPageActions
{
    #[NoReturn]
    public function save(): void
    {
        foreach ($this->settings as $key => $value) {
            Configuration::set($key, [
                'value' => $value,
            ]);
        }

        Configuration::loadConfigurations();

        Notification::make()
            ->success()
            ->title('Settings saved!')
            ->body('Settings saved!')
            ->send();
    }
}
