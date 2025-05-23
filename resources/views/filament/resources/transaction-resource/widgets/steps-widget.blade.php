<x-filament-widgets::widget>
    @vite('resources/css/app.css')
    <div class="w-full py-6">
        <div class="flex">
            @foreach($steps as $step)
                <livewire:step title="$step->title" />
            @endforeach
        </div>
    </div>
</x-filament-widgets::widget>
