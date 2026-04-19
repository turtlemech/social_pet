@props(['items' => []])

<x-ui.card>
    <h3 class="font-semibold text-gray-900 mb-3">Menú Rápido</h3>
    <div class="space-y-2">
        @foreach($items as $item)
            <a href="{{ route($item['route']) }}" 
               class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition group">
                <x-ui.icon name="{{ $item['icon'] }}" class="w-5 h-5 text-social-teal group-hover:scale-110 transition" />
                <span class="text-sm text-gray-700">{{ $item['name'] }}</span>
            </a>
        @endforeach
    </div>
</x-ui.card>