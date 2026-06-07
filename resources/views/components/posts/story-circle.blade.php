@props([
    'name',
    'avatar',
    'historia' => null,
    'hasStory' => true,
    'isAdd' => false
])

<div class="flex flex-col items-center space-y-1 flex-shrink-0">
    @if($isAdd)
    <div class="relative">

        <a
            href="{{ route('historias.crear') }}"
            class="w-16 h-16 rounded-full bg-gradient-to-tr from-gray-300 to-gray-400 flex items-center justify-center cursor-pointer hover:scale-105 transition"
        >
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4">
                </path>
            </svg>
        </a>

        <span class="absolute -bottom-1 -right-1 bg-social-teal text-white text-xs rounded-full px-1.5 py-0.5">
            +
        </span>

    </div>

    <span class="text-xs font-medium text-gray-600">
        Agregar historia
    </span>
@else
    <div class="relative">

    <div class="p-[2px] rounded-full bg-gradient-to-tr from-yellow-400 via-pink-500 to-purple-500">

       <img

    src="{{ $avatar }}"

    alt="{{ $name }}"

    @if($historia)

    onclick="window.location.href='{{ route('historias.ver', [

        'usuario' => $historia->usuario_id,

        'origen' => 'feed'

    ]) }}'"

    @endif

    class="w-16 h-16 rounded-full object-cover border-2 border-white cursor-pointer hover:scale-105 transition"

>
    </div>

</div>

    <span class="text-xs font-medium text-gray-700">
        {{ $name }}
    </span>
@endif
</div>