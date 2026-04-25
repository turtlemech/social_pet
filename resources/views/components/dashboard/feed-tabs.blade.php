@props(['tabs' => [], 'active' => 'Feed'])

<x-ui.card padding="p-2">
    <div class="flex">
        @foreach($tabs as $tab)
            <button 
                wire:click="$set('filter', '{{ strtolower($tab) }}')"
                class="flex-1 py-2 text-sm font-medium transition {{ 
                    $active === $tab 
                        ? 'text-social-teal border-b-2 border-social-teal' 
                        : 'text-gray-500 hover:text-gray-700' 
                }}">
                {{ $tab }}
            </button>
        @endforeach
    </div>
</x-ui.card>