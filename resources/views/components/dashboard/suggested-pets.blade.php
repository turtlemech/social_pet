@props(['pets' => []])

<x-ui.card>
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-900">Mascotas Sugeridas</h3>
    </div>
    
    <div class="space-y-3">
        @foreach($pets as $pet)
            <div class="flex items-center justify-between group">
                <div class="flex items-center space-x-3">

    @if(!empty($pet['avatar']))
        <img
            src="{{ $pet['avatar'] }}"
            alt="{{ $pet['name'] }}"
            class="w-10 h-10 rounded-full object-cover border"
        >
    @else
        <x-ui.avatar
            :name="$pet['name']"
            size="sm"
        />
    @endif
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
        <div class="mt-4 text-center">

    <a

        href="{{ route('sugerencias.index') }}"

        class="inline-block bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 transition"

    >

        Ver más sugerencias

    </a>

</div>
    </div>
</x-ui.card>