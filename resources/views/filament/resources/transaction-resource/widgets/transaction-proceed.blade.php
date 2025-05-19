<x-filament-widgets::widget>
    <x-filament::section>
        @vite('resources/css/app.css')
        {{-- build a line and three breakkpoints represent the steps of the proceed adn percentage --}}
        <div class="relative">
            <div class="w-full h-1 bg-gray-200 rounded-full">
                <div class="h-1 bg-blue-500 rounded-full" style="width: 50%"></div>
            </div>
            <div class="flex items-center justify-between w-full mt-2 absolute top-2 -translate-y-1/2">
                <span class="text-xs font-semibold text-gray-600 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center">0%</span>
                <span class="text-xs font-semibold text-gray-600 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center">50%</span>
                <span class="text-xs font-semibold text-gray-600 w-8 h-8 rounded-full bg-white shadow flex items-center justify-center">100%</span>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
