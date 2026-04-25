@props(['padding' => 'p-4'])

<div {{ $attributes->merge(['class' => "bg-white rounded-xl shadow-sm {$padding}"]) }}>
    {{ $slot }}
</div>