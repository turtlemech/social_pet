@props(['pets' => []])

<x-ui.card>
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-900">Mascotas Sugeridas</h3>
        <button class="text-xs text-social-teal font-medium hover:text-social-teal-dark">Ver más</button>
    </div>
    
    <div class="space-y-3">
        @foreach($pets as $pet)
            <div class="flex items-center justify-between group">
                <div class="flex items-center space-x-3">
                    <x-ui.avatar :name="$pet['name']" size="sm" />
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ $pet['name'] }}</p>
                        <p class="text-xs text-gray-500">{{ $pet['breed'] }} · {{ $pet['distance'] }}</p>
                    </div>
                </div>
                <button class="text-xs text-social-teal font-medium bg-teal-50 px-3 py-1 rounded-full hover:bg-teal-100 transition">
                    Seguir
                </button>
            </div>
        @endforeach
    </div>
</x-ui.card>