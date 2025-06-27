<x-filament-widgets::widget>
        @vite('resources/css/app.css')

        <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
            <div class="flex items-start gap-4">
                <img src="{{ $product->image_url }}" alt="{{ $product->title }}"
                     class="w-16 h-16 rounded-md object-cover shadow-sm">
                <div class="flex-1">
                    <h2 class="text-lg font-semibold text-gray-900">{{ $product->title }}</h2>
                    <p class="text-sm text-gray-600">SKU: <span class="font-medium">{{ $product->sku }}</span></p>
                    <div class="grid grid-cols-2 gap-2 mt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Category:</span>
                            <span
                                class="px-2 py-1 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-sm">{{ $product->category->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Unit:</span>
                            <span
                                class="px-2 py-1 text-sm font-medium text-white bg-green-600 rounded-lg shadow-sm">{{ $product->unity->name }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Quantity:</span>
                            <span
                                class="px-2 py-1 text-sm font-medium text-white bg-purple-600 rounded-lg shadow-sm">{{ $product->quantity }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-600">Sheets:</span>
                            <span
                                class="px-2 py-1 text-sm font-medium text-white bg-teal-600 rounded-lg shadow-sm">{{ $product->sheets }}</span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h3 class="text-sm font-semibold text-gray-700">Description:</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                    <div class="mt-3">
                        <h3 class="text-sm font-semibold text-gray-700">Remark:</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $product->remark }}</p>
                    </div>
                </div>
            </div>
        </div>
</x-filament-widgets::widget>
