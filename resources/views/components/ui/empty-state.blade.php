@props(['message' => 'No hay contenido', 'icon' => 'inbox'])

<div class="text-center py-12">
    <x-ui.icon name="{{ $icon }}" class="w-16 h-16 mx-auto text-gray-400" />
    <p class="mt-4 text-gray-500">{{ $message }}</p>
</div>