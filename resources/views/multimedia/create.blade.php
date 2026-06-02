@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-[#f0f2f5] py-6">

    <div class="max-w-4xl mx-auto px-4">

        <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-6 mb-6 shadow-lg text-white flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">🎵 Publicar Multimedia</h1>
                <p class="text-teal-100 text-sm mt-1">
                    Sube música o audios para compartir en Social Pet.
                </p>
            </div>

            <a href="{{ route('multimedia.index') }}"
               class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl font-bold transition">
                ← Volver
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

            <div class="h-48 bg-gradient-to-r from-gray-200 to-gray-300 relative" id="coverPreview">

                <div class="absolute inset-0 flex items-center justify-center text-gray-400">

                    <div class="text-center">
                        <div class="text-5xl mb-2">🎵</div>
                        <p>Vista previa de la portada</p>
                    </div>

                </div>

                <img id="coverImage"
                     class="w-full h-full object-cover hidden">

            </div>

            <div class="p-6">

                <form action="{{ route('multimedia.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            Título
                        </label>

                        <input
                            type="text"
                            name="titulo"
                            required
                            class="w-full border rounded-xl p-4 bg-gray-50">

                    </div>

                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            Artista
                        </label>

                        <input
                            type="text"
                            name="artista"
                            class="w-full border rounded-xl p-4 bg-gray-50">

                    </div>

                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            Descripción
                        </label>

                        <textarea
                            name="descripcion"
                            rows="4"
                            class="w-full border rounded-xl p-4 bg-gray-50"></textarea>

                    </div>

                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            Tipo
                        </label>

                        <select
                            name="tipo"
                            class="w-full border rounded-xl p-4 bg-gray-50">

                            <option value="musica">
                                🎵 Música
                            </option>

                            <option value="audio">
                                🎙️ Audio
                            </option>

                        </select>

                    </div>

                    {{-- ARCHIVO --}}
                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            Archivo de audio
                        </label>

                        <input
                            type="file"
                            name="archivo"
                            id="archivo"
                            accept="audio/*"
                            class="w-full border rounded-xl p-4">

                        <p id="audioName"
                           class="text-teal-600 text-sm mt-2 hidden"></p>

                    </div>

                    {{-- URL --}}
                    <div class="mb-4">

                        <label class="block font-bold mb-2">
                            O pega una URL de música/audio
                        </label>

                        <input
                            type="url"
                            name="url_audio"
                            placeholder="https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"
                            class="w-full border rounded-xl p-4 bg-gray-50">

                        <p class="text-xs text-gray-500 mt-2">
                            Puedes subir un archivo o pegar una URL directa.
                        </p>

                    </div>

                    {{-- PORTADA --}}
                    <div class="mb-6">

                        <label class="block font-bold mb-2">
                            Imagen de portada
                        </label>

                        <input
                            type="file"
                            name="portada"
                            id="portada"
                            accept="image/*"
                            onchange="previewImage(this)"
                            class="w-full border rounded-xl p-4">

                        <p id="portadaName"
                           class="text-teal-600 text-sm mt-2 hidden"></p>

                    </div>

                    <div class="flex gap-3">

                        <a href="{{ route('multimedia.index') }}"
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-center py-3 rounded-xl font-bold">
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            class="flex-1 bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl font-bold">
                            🎵 Publicar Multimedia
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>

function previewImage(input)
{
    if(input.files && input.files[0])
    {
        const reader = new FileReader();

        reader.onload = function(e)
        {
            document.getElementById('coverImage').src = e.target.result;
            document.getElementById('coverImage').classList.remove('hidden');

            document.querySelector('#coverPreview .absolute').classList.add('hidden');

            document.getElementById('portadaName').innerHTML =
                '🖼️ ' + input.files[0].name;

            document.getElementById('portadaName').classList.remove('hidden');
        };

        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('archivo').addEventListener('change', function(){

    if(this.files.length > 0)
    {
        document.getElementById('audioName').innerHTML =
            '🎵 ' + this.files[0].name;

        document.getElementById('audioName').classList.remove('hidden');
    }

});

</script>

@endsection