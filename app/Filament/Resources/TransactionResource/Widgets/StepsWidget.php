<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Filament\Resources\TransactionResource\Widgets\components\Step;
use Filament\Widgets\Widget;
use http\Exception\UnexpectedValueException;

class StepsWidget extends Widget
{
    protected int|string|array $columnSpan = 2;

    protected static bool $isLazy = false;

    protected array $steps = [];

    protected static string $view = 'filament.resources.transaction-resource.widgets.steps-widget';

    public function getSteps(): array
    {
        return $this->steps;
    }

    public static function steps(array $steps): static
    {
        if (count(array_filter($steps, fn ($step) => ! ($step instanceof Step))) > 0) {
            throw new UnexpectedValueException(sprintf('expected only type : %s, another type passed in steps method', Step::class));
        }

        $widget = new static;

        $widget->steps = $steps;

        return $widget;
    }
}
