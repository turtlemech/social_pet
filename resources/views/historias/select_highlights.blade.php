@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold">Seleccionar historias publicadas</h2>
            <p class="text-sm text-gray-500">Elige las historias que quieras mostrar como destacadas en tu perfil.</p>
        </div>
        <a href="{{ route('profile') }}" class="px-4 py-2 bg-gray-100 rounded">Volver</a>
    </div>

    @if($stories->count())
        <form action="{{ route('stories.highlights.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($stories as $story)
                    <label class="block bg-white rounded-lg overflow-hidden border shadow-sm">
                        <div class="relative h-40 bg-black">
                            @if($story->type === 'video')
                                <video class="w-full h-full object-cover" muted>
                                    <source src="{{ Storage::url($story->media) }}" type="video/mp4">
                                </video>
                                <div class="absolute inset-0 bg-black/30 flex items-center justify-center text-white">▶️</div>
                            @else
                                <img src="{{ Storage::url($story->media) }}" alt="story" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="p-3 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold">{{ $story->type === 'video' ? 'Historia en video' : 'Historia en imagen' }}</p>
                                <p class="text-xs text-gray-500">{{ $story->created_at->diffForHumans() }}</p>
                            </div>
                            <input type="checkbox" name="story_ids[]" value="{{ $story->id }}" class="h-5 w-5" {{ $story->is_highlighted ? 'checked' : '' }}>
                        </div>
                    </label>
                @endforeach
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="px-6 py-2 bg-teal-600 text-white rounded-lg">Agregar seleccionadas</button>
            </div>
        </form>
    @else
        <div class="rounded-lg border border-dashed border-gray-300 p-8 text-center text-gray-500">
            No tienes historias activas para seleccionar.
        </div>
    @endif

</div>

@endsection
