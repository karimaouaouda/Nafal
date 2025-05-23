<?php

namespace App\Livewire;

use Closure;
use Livewire\Component;

class Step extends Component
{
    public ?string $name = null;

    public string $icon;

    public string $description;

    public string $title;

    public bool $completed;

    public Closure $action;

    public function render()
    {
        return view('livewire.step');
    }
}
