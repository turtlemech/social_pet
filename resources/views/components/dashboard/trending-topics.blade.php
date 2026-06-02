@props(['mascotasPopulares' => []])

<x-ui.card>
    <h3 class="font-semibold text-gray-900 mb-3">
        🏆 Mascotas Populares
    </h3>

    <div class="space-y-3">

        @forelse($mascotasPopulares as $index => $mascota)

            <a
                href="{{ route('pets.show', $mascota->id) }}"
                class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition">

                <div class="text-lg font-bold">

                    @if($index == 0)
                        🥇
                    @elseif($index == 1)
                        🥈
                    @elseif($index == 2)
                        🥉
                    @endif

                </div>

                <img
                    src="{{ $mascota->foto_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($mascota->nom_mas) }}"
                    class="w-10 h-10 rounded-full object-cover">

                <div class="flex-1 min-w-0">

                    <p class="font-medium text-gray-900 truncate">
                        {{ $mascota->nom_mas }}
                    </p>

                    <p class="text-xs text-gray-500">
                        {{ $mascota->seguidores_count }} seguidores
                    </p>

                </div>

            </a>

        @empty

            <div class="text-sm text-gray-500 text-center py-4">
                Aún no hay mascotas populares
            </div>

        @endforelse

    </div>
</x-ui.card>