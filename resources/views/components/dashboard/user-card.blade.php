@props(['user'])

<x-ui.card>
    <div class="flex items-center space-x-3 mb-4">
        <x-ui.avatar :name="$user->name" size="lg" />
        <div>
            <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
            <p class="text-xs text-gray-500">Miembro desde {{ $user->created_at->format('M Y') }}</p>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-2 pt-3 border-t border-gray-100 text-center">
        <div>
            <p class="font-bold text-gray-900">{{ $user->posts_count ?? 0 }}</p>
            <p class="text-xs text-gray-500">Posts</p>
        </div>
        <div>
            <p class="font-bold text-gray-900">{{ $user->followers_count ?? 0 }}</p>
            <p class="text-xs text-gray-500">Seguidores</p>
        </div>
        <div>
            <p class="font-bold text-gray-900">{{ $user->following_count ?? 0 }}</p>
            <p class="text-xs text-gray-500">Siguiendo</p>
        </div>
    </div>
    
    <div class="mt-4 pt-3 border-t border-gray-100">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-ui.button variant="danger" size="sm" class="w-full">
                <div class="flex items-center justify-center space-x-2">
                    <x-ui.icon name="logout" class="w-4 h-4" />
                    <span>Cerrar Sesión</span>
                </div>
            </x-ui.button>
        </form>
    </div>
</x-ui.card>