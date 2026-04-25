@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
    $variants = [
        'primary' => 'bg-social-teal text-white hover:bg-social-teal-dark',
        'secondary' => 'bg-gray-200 text-gray-700 hover:bg-gray-300',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'outline' => 'border border-social-teal text-social-teal hover:bg-social-teal hover:text-white'
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base'
    ];
    
    $classes = $variants[$variant] . ' ' . $sizes[$size] . ' rounded-lg transition font-medium';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>