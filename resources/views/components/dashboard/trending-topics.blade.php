@props(['topics' => []])

<x-ui.card>
    <h3 class="font-semibold text-gray-900 mb-3">Tendencias</h3>
    <div class="space-y-2">
        @foreach($topics as $topic)
            <div class="cursor-pointer hover:bg-gray-50 p-2 rounded-lg transition group">
                <p class="text-xs text-gray-500 group-hover:text-social-teal">{{ $topic['name'] }}</p>
                <p class="text-sm font-medium text-gray-900">{{ number_format($topic['posts']) }} posts</p>
            </div>
        @endforeach
    </div>
</x-ui.card>