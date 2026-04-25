@props(['name', 'size' => 'md', 'src' => null])

@php
    $sizes = [
        'sm' => 'w-8 h-8',
        'md' => 'w-10 h-10',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16'
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    
    if(!$src) {
        $src = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=0d9488&color=fff&bold=true';
    }
@endphp

<img src="{{ $src }}" alt="{{ $name }}" class="{{ $sizeClass }} rounded-full object-cover">