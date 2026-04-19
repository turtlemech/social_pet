@props(['stories' => []])

<x-ui.card>
    <div class="flex justify-between items-center mb-3">
        <h3 class="font-semibold text-gray-900">Stories</h3>
        <button class="text-xs text-social-teal font-medium hover:text-social-teal-dark">Ver todas</button>
    </div>
    
    <div class="overflow-x-auto pb-2 -mx-2 px-2 stories-scroll">
        <div class="flex space-x-4">
            <x-posts.story-circle isAdd="true" />
            @foreach($stories as $story)
                <x-posts.story-circle 
                    name="{{ $story }}" 
                    avatar="https://ui-avatars.com/api/?name={{ $story }}&background=0d9488&color=fff&bold=true" 
                />
            @endforeach
        </div>
    </div>
</x-ui.card>