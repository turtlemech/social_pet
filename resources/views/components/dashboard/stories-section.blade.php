@props(['stories' => []])

<x-ui.card>
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-900">Stories</h3>
        <button class="text-xs text-social-teal font-medium hover:text-social-teal-dark">Ver todas</button>
    </div>
    
    <div class="overflow-x-auto pb-2 -mx-2 px-2 stories-scroll">
        <div class="flex space-x-4">
            <x-posts.story-circle isAdd="true" />
            @foreach($stories as $usuario)

    <x-posts.story-circle

    name="{{ $usuario->nom_us }}"

    avatar="{{ $usuario->ava_us

        ? asset('storage/'.$usuario->ava_us)

        : 'https://ui-avatars.com/api/?name='.urlencode($usuario->nom_us)

    }}"

    :historia="$usuario->historias->first()"

/>

@endforeach
        </div>
    </div>
</x-ui.card>