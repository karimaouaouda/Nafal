<?php

namespace App\Filament\Resources\UnityResource\Pages;

use App\Filament\Resources\UnityResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUnity extends CreateRecord
{
    protected static string $resource = UnityResource::class;

    protected static bool $canCreateAnother = false;
}
