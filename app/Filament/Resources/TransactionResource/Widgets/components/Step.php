<?php

namespace App\Filament\Resources\TransactionResource\Widgets\components;

use Closure;

class Step
{
    protected ?string $name = null;

    protected string $icon;

    protected string $description;

    protected string $title;

    protected bool $completed;

    protected Closure $action;

    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public function action(Closure $action): static
    {
        $this->action = $action;

        return $this;
    }

    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function icon(string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function completed(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }
}
